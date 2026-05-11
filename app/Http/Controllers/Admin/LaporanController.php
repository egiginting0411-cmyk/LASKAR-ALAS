<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BKPH;
use App\Models\Laporan;
use App\Models\RPH;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(BKPH $bkph, RPH $rph)
    {
        $laporan = Laporan::where('pegawai_id', $rph->pegawai_id)
            ->with('pegawai.user')
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get();

        return view('pages.admin.laporan.index', compact('bkph', 'rph', 'laporan'));
    }

    public function approve(Laporan $laporan)
    {
        try {
            // Cek apakah laporan masih dalam status 'proses'
            if ($laporan->status !== 'proses') {
                return response()->json([
                    'success' => false,
                    'message' => 'Laporan sudah tervalidasi atau tidak dapat diubah.'
                ], 422);
            }

            // Update status laporan
            $laporan->update(['status' => 'divalidasi']);

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil divalidasi.'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memvalidasi laporan.'
            ], 500);
        }
    }

    public function exportPdf($pegawaiId)
    {
        $laporan = Laporan::with(['pegawai.user'])
            ->where('pegawai_id', $pegawaiId)
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get();

        if ($laporan->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada laporan untuk pegawai ini.');
        }

        $namaPembuat = $laporan->first()->pegawai->user->name ?? '-';

        $pdf = Pdf::loadView(
            'pages.admin.laporan.pdf',
            [
                'laporan' => $laporan,
                'namaPembuat' => $namaPembuat
            ]
        )->setPaper('a4', 'landscape');

        return $pdf->stream('laporan.pdf');
    }
}
