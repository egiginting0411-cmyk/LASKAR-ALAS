<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BKPH;
use App\Models\Pegawai;
use App\Models\RPH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RPHController extends Controller
{
    public function index($bkphId)
    {
        $currentUser = auth()->user();
        $currentPegawai = Pegawai::where('user_id', $currentUser->id)->first();

        $bkphLogin = null;
        $isOwner = false;

        if ($currentPegawai) {
            $bkphLogin = BKPH::where('pegawai_id', $currentPegawai->id)->first();
        }

        $bkph = BKPH::findOrFail($bkphId);

        // Cek apakah BKPH yang dibuka adalah milik user login
        if ($bkphLogin && $bkphLogin->id == $bkph->id) {
            $isOwner = true;
        }

        $rph = RPH::with(['pegawai.user', 'bkph'])
            ->where('bkph_id', $bkph->id)
            ->get();

        $allPegawai = Pegawai::with('user')->get();

        return view('pages.admin.rph.index', compact(
            'rph',
            'bkph',
            'allPegawai',
            'isOwner'
        ));
    }

    public function create(Request $request)
    {
        $bkphId = $request->bkph_id;

        if (!$bkphId) {
            return back()->with('error', 'BKPH tidak ditemukan.');
        }

        $bkph = BKPH::findOrFail($bkphId);

        $pegawai = Pegawai::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->with('user')->get();

        return view('pages.admin.rph.create', compact('pegawai', 'bkph'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bkph_id'    => 'required|exists:bkph,id',
            'pegawai_id' => 'required|exists:pegawai,id',
            'sektor'     => 'required|string|max:255',
            'no_telp'    => 'required|string|max:20',
        ]);

        $pegawai = Pegawai::with('user')
            ->where('id', $request->pegawai_id)
            ->whereHas('user', fn($q) => $q->where('role', 'user'))
            ->first();

        if (!$pegawai) {
            return back()->with('error', 'Pegawai tidak ditemukan atau bukan role user.');
        }

        RPH::create([
            'bkph_id'    => $request->bkph_id,
            'pegawai_id' => $pegawai->id,
            'sektor'     => $request->sektor,
            'no_telp'    => $request->no_telp,
        ]);

        return redirect()->route('adminrph.index', $request->bkph_id)
            ->with('success', 'RPH berhasil ditambahkan.');
    }

    public function edit(RPH $rph)
    {
        $bkph = $rph->bkph;

        $pegawai = Pegawai::whereHas('user', fn($q) => $q->where('role', 'user'))
            ->with('user')
            ->get();

        return view('pages.admin.rph.edit', compact('rph', 'pegawai', 'bkph'));
    }

    public function update(Request $request, RPH $rph)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'sektor'     => 'required|string|max:255',
            'no_telp'    => 'required|string|max:20',
        ]);

        $pegawai = Pegawai::with('user')
            ->where('id', $request->pegawai_id)
            ->whereHas('user', fn($q) => $q->where('role', 'user'))
            ->first();

        if (!$pegawai) {
            return back()->with('error', 'Pegawai tidak ditemukan atau bukan role user.');
        }

        $rph->update([
            'pegawai_id' => $pegawai->id,
            'sektor'     => $request->sektor,
            'no_telp'    => $request->no_telp,
        ]);

        return redirect()->route('adminrph.index', $rph->bkph_id)
            ->with('success', 'Data RPH berhasil diperbarui.');
    }

    public function delete(RPH $rph)
    {
        $bkphId = $rph->bkph_id;

        $rph->delete();

        return redirect()->route('adminrph.index', $bkphId)
            ->with('success', 'Data RPH berhasil dihapus.');
    }
}
