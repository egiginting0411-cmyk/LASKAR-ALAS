<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petak extends Model
{
    use HasFactory;

    protected $table = 'petak';

    protected $fillable = [
        'rph_id',
        'nama_petak',
    ];

    public function rph()
    {
        return $this->belongsTo(RPH::class, 'rph_id');
    }
}
