<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\BKPH;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BKPHController extends Controller
{
    public function index()
    {
        $routeName = Route::currentRouteName();
        
        // Mapping route ke daerah + view path
        $mapping = [
            'bkphrogojampi.index' => [
                'daerah' => 'Rogojampi',
                'view'   => 'pages.super.bkph.rogojampi.index',
            ],
            'bkphlicin.index' => [
                'daerah' => 'Licin',
                'view'   => 'pages.super.bkph.licin.index',
            ],
            'bkphglenmore.index' => [
                'daerah' => 'Glenmore',
                'view'   => 'pages.super.bkph.glenmore.index',
            ],
            'bkphsempu.index' => [
                'daerah' => 'Sempu',
                'view'   => 'pages.super.bkph.sempu.index',
            ],
            'bkphkalibaru.index' => [
                'daerah' => 'Kalibaru',
                'view'   => 'pages.super.bkph.kalibaru.index',
            ],
        ];

        if (!isset($mapping[$routeName])) {
            abort(404);
        }

        $daerah = $mapping[$routeName]['daerah'];
        $view   = $mapping[$routeName]['view'];

        // Ambil data sesuai daerah
        $bkph = BKPH::where('daerah_bkph', $daerah)->get();

        return view($view, compact('bkph', 'daerah'));
    }

    public function create($daerah)
    {
        $pegawai = Pegawai::whereHas('user', function ($q) {
            $q->where('role', 'admin'); // filter hanya user role admin
        })->with('user')->get();

        return view('pages.super.bkph.create', compact('pegawai', 'daerah'));
    }

    public function store(Request $request, $daerah)
    {
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
            'daerah_bkph' => ucfirst($daerah),
        ]);

        return redirect()->route("bkph" . strtolower($daerah) . ".index")
            ->with('success', "Data BKPH $daerah berhasil ditambahkan!");
    }

    public function edit($daerah, $id)
    {
        $bkph = BKPH::findOrFail($id);
        $pegawai = Pegawai::whereHas('user', function ($q) {
            $q->where('role', 'admin'); // filter hanya user role admin
        })->with('user')->get();

        // Semua daerah pakai 1 view edit
        return view('pages.super.bkph.edit', compact('bkph', 'pegawai', 'daerah'));
    }

    public function update(Request $request, $daerah, $id)
    {
        $request->validate([
            'daerah_bkph' => 'required|string',
            'nama_rph' => 'required|string',
            'pegawai_id' => 'required|integer',
            'jumlah_polhuter' => 'required|numeric',
            'telp_kantor' => 'required|string',
        ]);

        $bkph = Bkph::findOrFail($id);
        $bkph->update($request->all());

        return redirect()->route("bkph" . strtolower($daerah) . ".index")
            ->with('success', "Data BKPH $daerah berhasil diupdate!");
    }

    public function delete($daerah, $id)
    {
        $bkph = Bkph::findOrFail($id);
        $bkph->delete();

        return redirect()->route("bkph" . strtolower($daerah) . ".index")
            ->with('success', "Data BKPH $daerah berhasil dihapus!");
    }
}
