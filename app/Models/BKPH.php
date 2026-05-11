<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BKPH extends Model
{
    use HasFactory;

    protected $table = 'bkph';

    protected $fillable = [
        'daerah_bkph',
        'nama_rph',
        'pegawai_id',
        'jumlah_polhuter',
        'telp_kantor',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function rph()
    {
        return $this->hasMany(RPH::class, 'bkph_id');
    }
}
