<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $jadwal = Jadwal::whereHas('pegawai', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->with(['pegawai.user'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->get();

        return view('pages.user.jadwal.index', compact('jadwal'));
    }
}
