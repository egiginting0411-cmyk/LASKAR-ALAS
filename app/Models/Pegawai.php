<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';

    protected $fillable = [
        'user_id',
        'nip',
        'jabatan',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bkph()
    {
        return $this->belongsTo(BKPH::class, 'bkph_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
    
    public function rph()
    {
        return $this->hasOne(RPH::class);
    }
}
