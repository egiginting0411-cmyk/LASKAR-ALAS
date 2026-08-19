<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BKPH;
use App\Models\Jadwal;
use App\Models\Pegawai;
use App\Models\RPH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    private function getAdminBkph()
    {
        $user = Auth::user();
        return BKPH::whereHas('pegawai', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();
    }

    public function index()
    {
        $bkph = $this->getAdminBkph();
        if (!$bkph) abort(403, 'Daerah BKPH belum ditentukan');

        $rphIds = RPH::where('bkph_id', $bkph->id)->pluck('pegawai_id');

        $jadwal = Jadwal::whereIn('pegawai_id', $rphIds)
            ->with(['pegawai.user', 'pegawai.rph'])
            ->get();

        return view('pages.admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $bkph = $this->getAdminBkph();
        if (!$bkph) abort(403, 'Daerah BKPH belum ditentukan');

        $pegawai = Pegawai::whereHas('user', fn($q) => $q->where('role', 'user'))
            ->whereHas('rph', fn($q) => $q->where('bkph_id', $bkph->id))
            ->whereDoesntHave('jadwal')
            ->with('user')
            ->get();

        return view('pages.admin.jadwal.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'hari'       => 'required|string',
            'tanggal'    => 'required|date',
            'waktu'      => 'required',
            'kegiatan'   => 'required|string',
        ]);

        $bkph = $this->getAdminBkph();
        if (!$bkph) abort(403, 'Daerah BKPH belum ditentukan');

        $isOwned = RPH::where('bkph_id', $bkph->id)
            ->where('pegawai_id', $request->pegawai_id)
            ->exists();

        if (!$isOwned) abort(403, 'Pegawai tidak termasuk dalam BKPH Anda');

        Jadwal::create($request->only([
            'pegawai_id', 'hari', 'tanggal', 'waktu', 'kegiatan'
        ]));

        return redirect()
            ->route('jadwalbkph.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $bkph = $this->getAdminBkph();
        if (!$bkph) abort(403, 'Daerah BKPH belum ditentukan');

        $jadwal->load('pegawai.rph');
        $jadwalRphBkph = $jadwal->pegawai->rph?->bkph_id;
        if ($jadwalRphBkph !== $bkph->id) abort(403);

        $pegawai = Pegawai::whereHas('user', fn($q) => $q->where('role', 'user'))
            ->whereHas('rph', fn($q) => $q->where('bkph_id', $bkph->id))
            ->with('user')
            ->get();

        return view('pages.admin.jadwal.edit', compact('jadwal', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'hari'       => 'required|string',
            'tanggal'    => 'required|date',
            'waktu'      => 'required',
            'kegiatan'   => 'required|string',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $bkph = $this->getAdminBkph();
        if (!$bkph) abort(403, 'Daerah BKPH belum ditentukan');

        $jadwal->load('pegawai.rph');
        $jadwalRphBkph = $jadwal->pegawai->rph?->bkph_id;
        if ($jadwalRphBkph !== $bkph->id) abort(403);

        $isOwned = RPH::where('bkph_id', $bkph->id)
            ->where('pegawai_id', $request->pegawai_id)
            ->exists();

        if (!$isOwned) abort(403, 'Pegawai tidak termasuk dalam BKPH Anda');

        $jadwal->update([
            'pegawai_id' => $request->pegawai_id,
            'hari'       => $request->hari,
            'tanggal'    => $request->tanggal,
            'waktu'      => $request->waktu,
            'kegiatan'   => $request->kegiatan,
        ]);

        return redirect()
            ->route('jadwalbkph.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    public function delete($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $bkph = $this->getAdminBkph();
        if (!$bkph) abort(403, 'Daerah BKPH belum ditentukan');

        $jadwal->load('pegawai.rph');
        $jadwalRphBkph = $jadwal->pegawai->rph?->bkph_id;
        if ($jadwalRphBkph !== $bkph->id) abort(403);

        $jadwal->delete();

        return redirect()
            ->route('jadwalbkph.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }

    public function exportPdf()
    {
        $bkph = $this->getAdminBkph();
        if (!$bkph) abort(403, 'Daerah BKPH belum ditentukan');

        $rphIds = RPH::where('bkph_id', $bkph->id)->pluck('pegawai_id');

        $jadwal = Jadwal::whereIn('pegawai_id', $rphIds)
            ->with(['pegawai.user', 'pegawai.rph'])
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'pages.admin.jadwal.pdf',
            ['jadwal' => $jadwal]
        )->setPaper('a4', 'landscape');

        return $pdf->stream('jadwal-polhut.pdf');
    }
}
