<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RPH extends Model
{
    use HasFactory;

    protected $table = 'rph';

    protected $fillable = [
        'bkph_id',
        'pegawai_id',
        'sektor',
        'no_telp',
    ];

    public function bkph()
    {
        return $this->belongsTo(BKPH::class, 'bkph_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }
}
