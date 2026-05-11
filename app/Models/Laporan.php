<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'pegawai_id',
        'sektor',
        'tanggal',
        'waktu',
        'uraian_kegiatan',
        'dokumentasi',
        'saksi',
        'status',
        'petak_hutan',
        'tanda_tangan',
    ];

    // relasi
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }
}
