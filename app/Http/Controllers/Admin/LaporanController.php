<?php

namespace App\Http\Controllers\Admin;

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

        // Cari KPH berdasarkan RPH yang terkait dengan pegawai ini
        $rph = \App\Models\RPH::where('pegawai_id', $pegawaiId)->first();
        $bkph = $rph ? $rph->bkph : null;
        $daerah = $bkph ? $bkph->daerah_bkph : null;

        // Data KPH berdasarkan daerah_bkph
        $kphData = [
            'Rogojampi' => [
                'nama' => 'Banyuwangi Barat',
                'alamat' => 'Jl. Jaksa Agung Soeprapto No. 34, Penganjuran, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68411',
                'telepon' => '(0333) 424327',
                'fax' => '(0333) 421649',
                'email' => 'kph.banyuwangibarat@perhutani.co.id',
            ],
            'Licin' => [
                'nama' => 'Banyuwangi Utara',
                'alamat' => 'Jl. Jaksa Agung Soeprapto No. 34, Penganjuran, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68411',
                'telepon' => '(0333) 421794',
                'fax' => '(0333) 421649',
                'email' => 'kph.banyuwangiutara@perhutani.co.id',
            ],
            'Glenmore' => [
                'nama' => 'Banyuwangi Selatan',
                'alamat' => 'Jl. Jaksa Agung Soeprapto No. 34, Penganjuran, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68411',
                'telepon' => '(0333) 421649',
                'fax' => '(0333) 411993',
                'email' => 'kph.banyuwangiselatan@perhutani.co.id',
            ],
            'Sempu' => [
                'nama' => 'Banyuwangi Selatan',
                'alamat' => 'Jl. Jaksa Agung Soeprapto No. 34, Penganjuran, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68411',
                'telepon' => '(0333) 421649',
                'fax' => '(0333) 411993',
                'email' => 'kph.banyuwangiselatan@perhutani.co.id',
            ],
            'Kalibaru' => [
                'nama' => 'Banyuwangi Selatan',
                'alamat' => 'Jl. Jaksa Agung Soeprapto No. 34, Penganjuran, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68411',
                'telepon' => '(0333) 421649',
                'fax' => '(0333) 411993',
                'email' => 'kph.banyuwangiselatan@perhutani.co.id',
            ],
        ];

        $kph = $daerah ? ($kphData[$daerah] ?? null) : null;

        return view('pages.admin.laporan.pdf', compact('laporan', 'namaPembuat', 'daerah', 'kph'));
    }
}
