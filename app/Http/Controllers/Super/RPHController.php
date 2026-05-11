<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\BKPH;
use App\Models\Pegawai;
use App\Models\RPH;
use Illuminate\Http\Request;

class RPHController extends Controller
{
    public function index(BKPH $bkph)
    {
        // Ambil semua RPH untuk bkph tertentu, termasuk pegawai & user
        $rph = RPH::where('bkph_id', $bkph->id)
            ->with('pegawai.user')
            ->get();

        // Ambil semua pegawai + user tanpa filter bkph
        $pegawai = Pegawai::with('user')->get();

        return view('pages.super.rph.index', compact('bkph', 'rph', 'pegawai'));
    }

    public function create(BKPH $bkph)
    {
        $pegawai = Pegawai::whereHas('user', fn($q) => $q->where('role', 'user'))
            ->with('user')
            ->get();

        return view('pages.super.rph.create', compact('bkph', 'pegawai'));
    }

    public function store(Request $request, BKPH $bkph)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'sektor' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        RPH::create([
            'bkph_id'   => $bkph->id,
            'pegawai_id' => $request->pegawai_id,
            'sektor'    => $request->sektor,
            'no_telp'   => $request->no_telp,
        ]);

        return redirect()->route('rph.index', $bkph->id)
            ->with('success', 'Data RPH berhasil ditambahkan.');
    }

    public function edit(BKPH $bkph, RPH $rph)
    {
        $pegawai = Pegawai::whereHas('user', fn($q) => $q->where('role', 'user'))
            ->with('user')
            ->get();

        return view('pages.super.rph.edit', compact('bkph', 'rph', 'pegawai'));
    }

    public function update(Request $request, BKPH $bkph, RPH $rph)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'sektor' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        $rph->update($request->only(['pegawai_id', 'sektor', 'no_telp']));

        return redirect()->route('rph.index', $bkph->id)
            ->with('success', 'Data RPH berhasil diperbarui.');
    }

    public function delete(BKPH $bkph, RPH $rph)
    {
        $rph->delete();

        return redirect()->route('rph.index', $bkph->id)
            ->with('success', 'Data RPH berhasil dihapus.');
    }
}
