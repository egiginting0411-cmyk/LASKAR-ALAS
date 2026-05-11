<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with(['pegawai.user', 'pegawai.rph'])
            ->get();

        return view('pages.super.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $pegawai = Pegawai::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'user');
            })
            ->get();

        return view('pages.super.jadwal.create', compact('pegawai'));
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

        Jadwal::create([
            'pegawai_id' => $request->pegawai_id,
            'hari'       => $request->hari,
            'tanggal'    => $request->tanggal,
            'waktu'      => $request->waktu,
            'kegiatan'   => $request->kegiatan,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal pegawai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $pegawai = Pegawai::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'user');
            })
            ->get();

        return view('pages.super.jadwal.edit', compact('jadwal', 'pegawai'));
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
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    public function delete($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}
