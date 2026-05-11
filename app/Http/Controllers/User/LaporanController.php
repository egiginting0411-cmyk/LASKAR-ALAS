<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // Menampilkan semua laporan milik user login
    public function index()
    {
        $userId = Auth::id();

        $laporan = Laporan::whereHas('pegawai', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->with(['pegawai.user']) // eager load untuk tampilkan nama/nomor telepon dst
            ->latest()
            ->get();

        return view('pages.user.laporan.index', compact('laporan'));
    }

    // Form tambah laporan
    public function create()
    {
        $pegawai = Pegawai::where('user_id', Auth::id())->first();
        $user = User::all();

        return view('pages.user.laporan.create', compact('pegawai', 'user'));
    }

    // Simpan laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'sektor' => 'required',
            'petak_hutan' => 'required|string|max:255',
            'uraian_kegiatan' => 'required|string|max:255',
            'dokumentasi' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'saksi' => 'required|string|max:255',
            'tanda_tangan' => 'required',
        ]);

        // Upload dokumentasi
        $path = null;
        if ($request->hasFile('dokumentasi')) {
            $path = $request->file('dokumentasi')->store('laporan', 'public');
        }

        // Upload tanda tangan (base64)
        $signaturePath = null;
        if ($request->tanda_tangan) {

            $image = str_replace('data:image/png;base64,', '', $request->tanda_tangan);
            $image = str_replace(' ', '+', $image);

            $imageName = 'ttd_' . time() . '.png';

            Storage::disk('public')->put(
                'tanda_tangan/' . $imageName,
                base64_decode($image)
            );

            $signaturePath = 'tanda_tangan/' . $imageName;
        }

        // cari pegawai berdasarkan user login
        $pegawai = Pegawai::where('user_id', Auth::id())->first();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan');
        }

        Laporan::create([
            'pegawai_id' => $pegawai->id,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'sektor' => $request->sektor,
            'petak_hutan' => $request->petak_hutan,
            'uraian_kegiatan' => $request->uraian_kegiatan,
            'dokumentasi' => $path,
            'saksi' => $request->saksi,
            'tanda_tangan' => $signaturePath,
            'status' => 'proses',
        ]);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan');
    }

    // Form edit laporan
    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        $user = User::all();
        return view('pages.user.laporan.edit', compact('laporan', 'user'));
    }

    // Update laporan
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'sektor' => 'required',
            'petak_hutan' => 'required|string|max:255',
            'uraian_kegiatan' => 'required|string|max:255',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'saksi' => 'required|string|max:255',
            'tanda_tangan' => 'nullable',
        ]);

        // Update dokumentasi jika ada
        if ($request->hasFile('dokumentasi')) {

            if ($laporan->dokumentasi) {
                Storage::disk('public')->delete($laporan->dokumentasi);
            }

            $path = $request->file('dokumentasi')->store('laporan', 'public');
            $laporan->dokumentasi = $path;
        }

        // Update tanda tangan jika ada
        if ($request->tanda_tangan) {

            if ($laporan->tanda_tangan) {
                Storage::disk('public')->delete($laporan->tanda_tangan);
            }

            $image = str_replace('data:image/png;base64,', '', $request->tanda_tangan);
            $image = str_replace(' ', '+', $image);

            $imageName = 'ttd_' . time() . '.png';

            Storage::disk('public')->put(
                'tanda_tangan/' . $imageName,
                base64_decode($image)
            );

            $laporan->tanda_tangan = 'tanda_tangan/' . $imageName;
        }

        $laporan->update([
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'sektor' => $request->sektor,
            'petak_hutan' => $request->petak_hutan,
            'uraian_kegiatan' => $request->uraian_kegiatan,
            'saksi' => $request->saksi,
        ]);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil diperbarui');
    }

    // Delete laporan
    public function delete($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->dokumentasi) {
            Storage::disk('public')->delete($laporan->dokumentasi);
        }

        if ($laporan->tanda_tangan) {
            Storage::disk('public')->delete($laporan->tanda_tangan);
        }

        $laporan->delete();

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
}
