<?php

use App\Http\Controllers\Admin\BKPHController as AdminBKPHController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\RPHController as AdminRPHController;
use App\Http\Controllers\Super\BKPHController;
use App\Http\Controllers\Super\PegawaiController;
use App\Http\Controllers\Super\RPHController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Super\DashboardController;
use App\Http\Controllers\Super\JadwalController;
use App\Http\Controllers\Super\LaporanController as SuperLaporanController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\JadwalController as UserJadwalController;
use App\Http\Controllers\User\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:super'])->group(function () {
    Route::prefix('/super')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('super.dashboard');

        //Pegawai
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai/{id}', [PegawaiController::class, 'delete'])->name('pegawai.delete');

        //Jadwal
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'delete'])->name('jadwal.delete');

        //BKPH Rogojampi
        Route::get('/bkphrogojampi', [BKPHController::class, 'index'])->name('bkphrogojampi.index');

        //BKPH Licin
        Route::get('/bkphlicin', [BKPHController::class, 'index'])->name('bkphlicin.index');

        //BKPH Glenmore
        Route::get('/bkphglenmore', [BKPHController::class, 'index'])->name('bkphglenmore.index');

        //BKPH Sempu
        Route::get('/bkphsempu', [BKPHController::class, 'index'])->name('bkphsempu.index');

        //BKPH Kalibaru
        Route::get('/bkphkalibaru', [BKPHController::class, 'index'])->name('bkphkalibaru.index');

        Route::get('/{daerah}/create', [BKPHController::class, 'create'])->name('bkph.create');
        Route::post('/{daerah}/store', [BKPHController::class, 'store'])->name('bkph.store');
        Route::get('/{daerah}/{id}/edit', [BKPHController::class, 'edit'])->name('bkph.edit');
        Route::put('/{daerah}/{id}/update', [BKPHController::class, 'update'])->name('bkph.update');
        Route::delete('/{daerah}/{id}/delete', [BKPHController::class, 'delete'])->name('bkph.delete');

        //RPH
        Route::get('/bkph/{bkph}/rph', [RPHController::class, 'index'])->name('rph.index');
        Route::get('/bkph/{bkph}/rph/create', [RPHController::class, 'create'])->name('rph.create');
        Route::post('/bkph/{bkph}/rph', [RPHController::class, 'store'])->name('rph.store');
        Route::get('/bkph/{bkph}/rph/{rph}/edit', [RPHController::class, 'edit'])->name('rph.edit');
        Route::put('/bkph/{bkph}/rph/{rph}', [RPHController::class, 'update'])->name('rph.update');
        Route::delete('/bkph/{bkph}/rph/{rph}', [RPHController::class, 'delete'])->name('rph.delete');

        Route::get('/bkph/{bkph}/rph/{rph}/laporan', [SuperLaporanController::class, 'index'])
            ->name('superlaporan.index');
    });
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
        Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
        Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
        Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
        Route::delete('/laporan/{id}', [LaporanController::class, 'delete'])->name('laporan.delete');

        Route::get('/jadwal', [UserJadwalController::class, 'index'])->name('jadwaluser.index');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/bkph', [AdminBKPHController::class, 'index'])->name('adminbkph.index');
        Route::get('/bkph/create', [AdminBKPHController::class, 'create'])->name('adminbkph.create');
        Route::post('/bkph', [AdminBKPHController::class, 'store'])->name('adminbkph.store');
        Route::get('/bkph/{bkph}/edit', [AdminBKPHController::class, 'edit'])->name('adminbkph.edit');
        Route::put('/bkph/{bkph}', [AdminBKPHController::class, 'update'])->name('adminbkph.update');
        Route::delete('/bkph/{bkph}', [AdminBKPHController::class, 'delete'])->name('adminbkph.delete');

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/rph/{bkph}', [AdminRPHController::class, 'index'])->name('adminrph.index');
        Route::get('/rph/create', [AdminRPHController::class, 'create'])->name('adminrph.create');
        Route::post('/rph', [AdminRPHController::class, 'store'])->name('adminrph.store');
        Route::get('/rph/{rph}/edit', [AdminRPHController::class, 'edit'])->name('adminrph.edit');
        Route::put('/rph/{rph}', [AdminRPHController::class, 'update'])->name('adminrph.update');
        Route::delete('/rph/{rph}', [AdminRPHController::class, 'delete'])->name('adminrph.delete');

        Route::get('/rph/{rph}/laporan', [AdminLaporanController::class, 'index'])->name('adminlaporan.index');
        Route::patch('/laporan/{laporan}/approve', [AdminLaporanController::class, 'approve'])->name('laporan.approve');
        Route::get('/laporan/export/{pegawai}', [AdminLaporanController::class, 'exportPdf'])->name('laporan.export');

        Route::get('/jadwal', [AdminJadwalController::class, 'index'])->name('jadwalbkph.index');
        Route::get('/jadwal/create', [AdminJadwalController::class, 'create'])->name('jadwalbkph.create');
        Route::post('/jadwal', [AdminJadwalController::class, 'store'])->name('jadwalbkph.store');
        Route::get('/jadwal/{id}/edit', [AdminJadwalController::class, 'edit'])->name('jadwalbkph.edit');
        Route::put('/jadwal/{id}', [AdminJadwalController::class, 'update'])->name('jadwalbkph.update');
        Route::delete('/jadwal/{id}', [AdminJadwalController::class, 'delete'])->name('jadwalbkph.delete');
    });
});

require __DIR__ . '/auth.php';
