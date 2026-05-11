<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('user')->get(); // ambil pegawai + relasi user
        return view('pages.super.pegawai.index', compact('pegawai'));
    }

    // Form create
    public function create()
    {
        // ambil semua user untuk pilihan (misalnya dropdown)
        $users = User::all();
        return view('pages.super.pegawai.create', compact('users'));
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string|max:50|unique:pegawai,nip',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
        ]);

        if ($request->filled('role')) {
            $user = User::findOrFail($request->user_id);
            $user->role = $request->role;
            $user->save();
        }

        // Simpan data pegawai
        Pegawai::create([
            'user_id' => $request->user_id,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    // Form Edit
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $users = User::all();
        return view('pages.super.pegawai.edit', compact('pegawai', 'users'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string|max:50|unique:pegawai,nip,' . $pegawai->id,
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
        ]);

        if ($request->filled('role')) {
            $user = User::findOrFail($request->user_id);
            $user->role = $request->role;
            $user->save();
        }

        $pegawai->update([
            'user_id' => $request->user_id,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    // Hapus data
    public function delete($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
