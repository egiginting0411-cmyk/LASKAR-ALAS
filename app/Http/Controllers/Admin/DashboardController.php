<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BKPH;
use App\Models\Pegawai;
use App\Models\RPH;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPegawai = Pegawai::count();
        $totalBkph = BKPH::count();
        $totalRph = RPH::count();

        $pegawai = Pegawai::latest()->take(5)->get();
        $bkph = Bkph::latest()->take(5)->get();
        $rph = Rph::latest()->take(5)->get();

        return view('pages.admin.index', compact('totalPegawai', 'totalBkph', 'totalRph', 'pegawai', 'bkph', 'rph'));
    }
}
