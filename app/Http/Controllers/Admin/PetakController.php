<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petak;
use App\Models\RPH;
use Illuminate\Http\Request;

class PetakController extends Controller
{
    public function all()
    {
        $rph = RPH::with(['bkph', 'petak'])->get();

        return view('pages.admin.petak.all', compact('rph'));
    }

    public function index($rphId)
    {
        $rph = RPH::with('bkph')->findOrFail($rphId);
        $petak = Petak::where('rph_id', $rphId)->get();

        return view('pages.admin.petak.index', compact('rph', 'petak'));
    }

    public function create($rphId)
    {
        $rph = RPH::with('bkph')->findOrFail($rphId);

        return view('pages.admin.petak.create', compact('rph'));
    }

    public function store(Request $request, $rphId)
    {
        $request->validate([
            'nama_petak' => 'required|string|max:255',
        ]);

        Petak::create([
            'rph_id' => $rphId,
            'nama_petak' => $request->nama_petak,
        ]);

        return redirect()->route('adminpetak.index', $rphId)
            ->with('success', 'Petak berhasil ditambahkan.');
    }

    public function edit($petakId)
    {
        $petak = Petak::with('rph')->findOrFail($petakId);
        $rph = $petak->rph;

        return view('pages.admin.petak.edit', compact('petak', 'rph'));
    }

    public function update(Request $request, $petakId)
    {
        $petak = Petak::findOrFail($petakId);

        $request->validate([
            'nama_petak' => 'required|string|max:255',
        ]);

        $petak->update([
            'nama_petak' => $request->nama_petak,
        ]);

        return redirect()->route('adminpetak.index', $petak->rph_id)
            ->with('success', 'Petak berhasil diperbarui.');
    }

    public function delete($petakId)
    {
        $petak = Petak::findOrFail($petakId);
        $rphId = $petak->rph_id;

        $petak->delete();

        return redirect()->route('adminpetak.index', $rphId)
            ->with('success', 'Petak berhasil dihapus.');
    }
}
