<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\JenisProgramController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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



require __DIR__.'/auth.php';
