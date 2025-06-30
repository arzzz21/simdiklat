<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\JenisProgramController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Dosen\PengajuanController;

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
Route::resource('pengajuan', PengajuanController::class);

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
    Route::resource('pengajuan', PengajuanController::class)->except('show');
});


require __DIR__.'/auth.php';
