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
    public function index()
    {
        $jadwal = Jadwal::with(['pegawai.user', 'pegawai.rph'])->get();

        return view('pages.admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $pegawai = Pegawai::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'user');
            })->get();

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

        Jadwal::create($request->only([
            'pegawai_id',
            'hari',
            'tanggal',
            'waktu',
            'kegiatan'
        ]));

        return redirect()
            ->route('jadwalbkph.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $pegawai = Pegawai::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'user');
            })
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

    /**
     * Hapus jadwal
     */
    public function delete($id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect()
            ->route('jadwalbkph.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}
