<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BKPH;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BKPHController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $bkphUser = BKPH::whereHas('pegawai', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        if (!$bkphUser) {
            return view('pages.admin.bkph.index', [
                'bkph' => collect(),
                'daerah' => '-'
            ]);
        }

        $daerah = $bkphUser->daerah_bkph;

        $bkph = BKPH::where('daerah_bkph', $daerah)->get();

        return view('pages.admin.bkph.index', compact('bkph', 'daerah'));
    }

    public function create()
    {
        $user = Auth::user();

        $bkphUser = BKPH::whereHas('pegawai', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        if (!$bkphUser) {
            abort(403, 'Daerah BKPH untuk akun ini belum ditentukan');
        }

        $daerah = $bkphUser->daerah_bkph;

        $pegawai = Pegawai::whereHas('user', function ($q) {
            $q->where('role', 'admin');
        })->with('user')->get();

        return view('pages.admin.bkph.create', compact('pegawai', 'daerah'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Ambil daerah BKPH dari user login
        $bkphUser = BKPH::whereHas('pegawai', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        if (!$bkphUser) {
            abort(403, 'Daerah BKPH untuk akun ini belum ditentukan');
        }

        $daerah = $bkphUser->daerah_bkph;

        $request->validate([
            'nama_rph' => 'required|string|max:255',
            'pegawai_id' => 'required|exists:pegawai,id',
            'jumlah_polhuter' => 'required|integer',
            'telp_kantor' => 'required|string|max:20',
        ]);

        BKPH::create([
            'nama_rph' => $request->nama_rph,
            'pegawai_id' => $request->pegawai_id,
            'jumlah_polhuter' => $request->jumlah_polhuter,
            'telp_kantor' => $request->telp_kantor,
            'daerah_bkph' => $daerah, // ⬅ otomatis, TANPA input admin
        ]);

        return redirect()
            ->route('adminbkph.index')
            ->with('success', "Data BKPH $daerah berhasil ditambahkan!");
    }

    public function edit(BKPH $bkph)
    {
        $user = Auth::user();

        // Ambil daerah BKPH user login (SAMA seperti create)
        $bkphUser = BKPH::whereHas('pegawai', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        if (!$bkphUser) {
            abort(403, 'Daerah BKPH belum ditentukan untuk akun ini');
        }

        $daerahUser = $bkphUser->daerah_bkph;

        // ❗ Proteksi: admin tidak boleh edit BKPH beda daerah
        if ($bkph->daerah_bkph !== $daerahUser) {
            abort(403, 'Anda tidak memiliki akses ke data BKPH ini');
        }

        $pegawai = Pegawai::whereHas('user', function ($q) {
            $q->where('role', 'admin');
        })->with('user')->get();

        return view('pages.admin.bkph.edit', compact('bkph', 'pegawai', 'daerahUser'));
    }

    public function update(Request $request, BKPH $bkph)
    {
        $user = Auth::user();

        // Ambil daerah BKPH user login (SAMA seperti create)
        $bkphUser = BKPH::whereHas('pegawai', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        if (!$bkphUser) {
            abort(403, 'Daerah BKPH belum ditentukan untuk akun ini');
        }

        $daerahUser = $bkphUser->daerah_bkph;

        // Proteksi daerah
        if ($bkph->daerah_bkph !== $daerahUser) {
            abort(403, 'Anda tidak memiliki akses ke data BKPH ini');
        }

        $request->validate([
            'nama_rph' => 'required|string|max:255',
            'pegawai_id' => 'required|exists:pegawai,id',
            'jumlah_polhuter' => 'required|integer',
            'telp_kantor' => 'required|string|max:20',
        ]);

        $bkph->update([
            'nama_rph' => $request->nama_rph,
            'pegawai_id' => $request->pegawai_id,
            'jumlah_polhuter' => $request->jumlah_polhuter,
            'telp_kantor' => $request->telp_kantor,
            'daerah_bkph' => $daerahUser, // 🔒 tidak boleh berubah
        ]);

        return redirect()
            ->route('adminbkph.index')
            ->with('success', "Data BKPH $daerahUser berhasil diperbarui!");
    }

    public function delete(BKPH $bkph)
    {
        $user = Auth::user();

        // Ambil daerah BKPH user login (SAMA seperti create & edit)
        $bkphUser = BKPH::whereHas('pegawai', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        if (!$bkphUser) {
            abort(403, 'Daerah BKPH belum ditentukan untuk akun ini');
        }

        $daerahUser = $bkphUser->daerah_bkph;

        // Proteksi: admin tidak boleh hapus BKPH beda daerah
        if ($bkph->daerah_bkph !== $daerahUser) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data ini');
        }

        $bkph->delete();

        return redirect()
            ->route('adminbkph.index')
            ->with('success', "Data BKPH $daerahUser berhasil dihapus!");
    }
}
