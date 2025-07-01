<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\JenisProgramController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Dosen\PengajuanController as DosenPengajuanController;
use App\Http\Controllers\Admin\BerkasController as AdminBerkasController;
use App\Http\Controllers\Dosen\BerkasController as DosenBerkasController;


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//DASHBOARD
Route::get('/dashboard', function () {
    return redirect('/redirect-after-login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin', fn () => view('admin.dashboard'));
    Route::get('/dosen', fn () => view('dosen.dashboard'));
});

Route::get('/redirect-after-login', function () {
    $user = auth()->user();
    return $user->hasRole('admin') ? redirect('/admin') :
           ($user->hasRole('dosen') ? redirect('/dosen') :
           abort(403));
});

//RESOURCE ROUTE
Route::resource('kampus', KampusController::class);
Route::resource('mahasiswa', MahasiswaController::class);
Route::resource('jenis-program', JenisProgramController::class);

//KAMPUS
Route::middleware('auth')->group(function () {
    Route::resource('kampus', KampusController::class);
});

//MAHASISWA
Route::resource('mahasiswa', MahasiswaController::class)->middleware('auth');

//JENIS PROGRAM
Route::middleware('auth')->group(function () {
    Route::resource('jenis-program', App\Http\Controllers\JenisProgramController::class)->except('show');
});

//TAMBAH DOSEN
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('dosen', DosenController::class)->except('show');
// });
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('dosen', DosenController::class)->except('show');
});

//Pengajuan PKL/Magang
Route::middleware(['auth'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::resource('pengajuan', DosenPengajuanController::class)->except('show');
});

//Verifikasi Pengajuan
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('admin.pengajuan.index');
    Route::post('/pengajuan/{id}/verifikasi', [AdminPengajuanController::class, 'verifikasi'])->name('admin.pengajuan.verifikasi');
});

//Berkas Pengajuan
Route::get('/pengajuan/{id}/berkas', [DosenBerkasController::class, 'index'])->name('dosen.pengajuan.berkas');
Route::post('/pengajuan/{id}/berkas', [DosenBerkasController::class, 'store'])->name('dosen.pengajuan.berkas.store');
Route::delete('/berkas/{id}', [DosenBerkasController::class, 'destroy'])->name('dosen.pengajuan.berkas.destroy');

//Verifikasi Berkas
// Route::prefix('admin')->middleware(['auth'])->group(function () {
// Route::get('/berkas', [AdminBerkasController::class, 'index'])->name('admin.berkas.index');
// Route::post('/berkas/{id}/verifikasi', [AdminBerkasController::class, 'verifikasi'])->name('admin.berkas.verifikasi');
// });
Route::get('/pengajuan/verifikasi', [AdminPengajuanController::class, 'verifikasiIndex'])->name('admin.pengajuan.verifikasi.index');
Route::get('/pengajuan/{id}/verifikasi-berkas', [AdminPengajuanController::class, 'verifikasiForm'])->name('admin.pengajuan.verifikasi.form');
Route::post('/pengajuan/{id}/verifikasi-berkas', [AdminPengajuanController::class, 'verifikasiBerkas'])->name('admin.pengajuan.verifikasi.submit');




require __DIR__.'/auth.php';
