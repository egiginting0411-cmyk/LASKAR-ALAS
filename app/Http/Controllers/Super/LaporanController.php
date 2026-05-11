<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\BKPH;
use App\Models\Laporan;
use App\Models\RPH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(BKPH $bkph, RPH $rph)
    {
        // $rph sudah instance model karena Route Model Binding
        $laporan = Laporan::where('pegawai_id', $rph->pegawai_id)
            ->with('pegawai.user')
            ->get();
        $rph = RPH::where('bkph_id', $bkph->id)->first();
        return view('pages.super.laporan.index', compact('bkph', 'rph', 'laporan'));
    }
}
