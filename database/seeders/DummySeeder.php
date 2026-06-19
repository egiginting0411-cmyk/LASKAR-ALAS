<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\BKPH;
use App\Models\RPH;
use App\Models\Jadwal;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // Buat user role user
        $users = [
            ['name' => 'Dewi Anggraini', 'email' => 'dewi.anggraini@gmail.com', 'nip' => '198501152010012005', 'jabatan' => 'Polisi Hutan', 'alamat' => 'Jl. Merdeka No. 10, Banyuwangi'],
            ['name' => 'Eko Saputra', 'email' => 'eko.saputra@gmail.com', 'nip' => '198703202012011008', 'jabatan' => 'Polisi Hutan', 'alamat' => 'Jl. Sudirman No. 25, Genteng'],
            ['name' => 'Rina Wulandari', 'email' => 'rina.wulandari@gmail.com', 'nip' => '199005102015012003', 'jabatan' => 'Polisi Hutan', 'alamat' => 'Jl. Pahlawan No. 8, Rogojampi'],
            ['name' => 'Ahmad Hidayat', 'email' => 'ahmad.hidayat@gmail.com', 'nip' => '198807182013011006', 'jabatan' => 'Polisi Hutan', 'alamat' => 'Jl. Ken Arok No. 3, Glenmore'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@gmail.com', 'nip' => '199201252018012004', 'jabatan' => 'Polisi Hutan', 'alamat' => 'Jl. Ahmad Yani No. 12, Kalibaru'],
        ];

        $pegawais = [];
        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('12341234'),
                    'role' => 'user',
                ]
            );

            $pegawai = Pegawai::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $userData['nip'],
                    'jabatan' => $userData['jabatan'],
                    'alamat' => $userData['alamat'],
                ]
            );
            $pegawais[] = $pegawai;
        }

        // Buat BKPH
        $bkphData = [
            ['daerah_bkph' => 'Rogojampi', 'nama_rph' => 'RPH Rogojampi', 'jumlah_polhuter' => '12', 'telp_kantor' => '0333-631234'],
            ['daerah_bkph' => 'Licin', 'nama_rph' => 'RPH Licin', 'jumlah_polhuter' => '10', 'telp_kantor' => '0333-632345'],
            ['daerah_bkph' => 'Glenmore', 'nama_rph' => 'RPH Glenmore', 'jumlah_polhuter' => '15', 'telp_kantor' => '0333-633456'],
        ];

        $bkphs = [];
        foreach ($bkphData as $i => $bkph) {
            $b = BKPH::updateOrCreate(
                ['daerah_bkph' => $bkph['daerah_bkph']],
                [
                    'nama_rph' => $bkph['nama_rph'],
                    'pegawai_id' => $pegawais[$i]->id,
                    'jumlah_polhuter' => $bkph['jumlah_polhuter'],
                    'telp_kantor' => $bkph['telp_kantor'],
                ]
            );
            $bkphs[] = $b;
        }

        // Buat RPH
        foreach ($pegawais as $i => $pegawai) {
            $bkphIndex = $i % count($bkphs);
            RPH::updateOrCreate(
                ['pegawai_id' => $pegawai->id],
                [
                    'bkph_id' => $bkphs[$bkphIndex]->id,
                    'sektor' => 'Sektor ' . ($i + 1),
                    'no_telp' => '0812345678' . ($i + 10),
                ]
            );
        }

        // Buat Jadwal
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $kegiatanList = [
            'Patroli Rutin Kawasan Hutan',
            'Pengawasan Hutan Lindung',
            'Pencegahan Kebakaran Hutan',
            'Monitoring Satwa Liar',
            'Penanaman Bibit Pohon',
            'Pembersihan Jalur Trekking',
            'Sosialisasi Konservasi Hutan',
            'Pemetaan Kawasan Hutan',
            'Inspeksi Blok Hutan',
            'Evaluasi Program RHL',
        ];

        $jadwalId = 1;
        foreach ($pegawais as $i => $pegawai) {
            $hari = $hariList[$i % count($hariList)];
            $tanggal = date('Y-m-d', strtotime('2026-06-22') + ($i * 86400));

            Jadwal::create([
                'pegawai_id' => $pegawai->id,
                'hari' => $hari,
                'tanggal' => $tanggal,
                'waktu' => '07:00',
                'kegiatan' => $kegiatanList[$i % count($kegiatanList)],
            ]);

            Jadwal::create([
                'pegawai_id' => $pegawai->id,
                'hari' => $hariList[($i + 1) % count($hariList)],
                'tanggal' => date('Y-m-d', strtotime($tanggal) + 86400),
                'waktu' => '08:30',
                'kegiatan' => $kegiatanList[($i + 2) % count($kegiatanList)],
            ]);

            Jadwal::create([
                'pegawai_id' => $pegawai->id,
                'hari' => $hariList[($i + 2) % count($hariList)],
                'tanggal' => date('Y-m-d', strtotime($tanggal) + 172800),
                'waktu' => '06:30',
                'kegiatan' => $kegiatanList[($i + 3) % count($kegiatanList)],
            ]);
        }
    }
}
