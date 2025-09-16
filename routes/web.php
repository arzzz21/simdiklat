<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\JenisProgramController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Dosen\PengajuanController as DosenPengajuanController;
use App\Http\Controllers\Admin\BerkasController as AdminBerkasController;
use App\Http\Controllers\Dosen\BerkasController as DosenBerkasController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Dosen\InvoiceController as DosenInvoiceController;
use App\Http\Controllers\Dosen\SuratController as DosenSuratController;
use App\Http\Controllers\Dosen\SertifikatController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Admin\PegawaiUserController;
use App\Http\Controllers\Admin\PelatihanController as AdminPelatihanController;
use App\Http\Controllers\Pegawai\PelatihanController as PegawaiPelatihanController;
use App\Http\Controllers\Pegawai\LaporanController as PegawaiLaporanController;
use App\Http\Controllers\Manajer\LaporanController as ManajerLaporanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\IhtController as AdminIhtController;
use App\Http\Controllers\Pegawai\IhtController as PegawaiIhtController;



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
    // Route::get('/admin', fn () => view('admin.dashboard'));
    Route::get('/admin', [AdminDashboardController::class, 'indexAdmin'])->name('admin.dashboard');
    // Route::get('/dosen', fn () => view('dosen.dashboard'));
    Route::get('/dosen', [DosenDashboardController::class, 'indexDosen'])->name('dosen.dashboard');
    Route::get('/pegawai', [PegawaiDashboardController::class, 'indexPegawai'])->name('pegawai.dashboard');
});

Route::get('/redirect-after-login', function () {
    $user = auth()->user();
    return $user->hasRole('admin') ? redirect('/admin') :
           ($user->hasRole('dosen') ? redirect('/dosen') :
           ($user->hasRole('pegawai') ? redirect('/pegawai') :
           abort(403)));
});

//RESOURCE ROUTE
Route::resource('kampus', KampusController::class);
Route::resource('mahasiswa', MahasiswaController::class);
Route::resource('fakultas', FakultasController::class);
Route::resource('prodi', ProdiController::class);
Route::resource('jenis-program', JenisProgramController::class);

//KAMPUS
Route::middleware('auth')->group(function () {
    Route::resource('kampus', KampusController::class);
});

//FAKULTAS
Route::middleware('auth')->group(function () {
    Route::resource('fakultas', FakultasController::class);
});
Route::get('/admin/get-fakultas-by-kampus/{kampus_id}', [DosenController::class, 'getFakultasByKampus']);

//PRODI
Route::middleware('auth')->group(function () {
    Route::resource('prodi', ProdiController::class);
});
Route::get('/admin/get-prodi-by-kampus/{kampus_id}', [MahasiswaController::class, 'getProdiByKampus']);

//MAHASISWA
Route::resource('mahasiswa', MahasiswaController::class)->middleware('auth');

//JENIS PROGRAM
Route::middleware('auth')->group(function () {
    Route::resource('jenis-program', App\Http\Controllers\JenisProgramController::class)->except('show');
});

//TAMBAH DOSEN
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
Route::get('/pengajuan/verifikasi', [AdminPengajuanController::class, 'verifikasiIndex'])->name('admin.pengajuan.verifikasi.index');
Route::get('/pengajuan/{id}/verifikasi-berkas', [AdminPengajuanController::class, 'verifikasiForm'])->name('admin.pengajuan.verifikasi.form');
Route::post('/pengajuan/{id}/verifikasi-berkas', [AdminPengajuanController::class, 'verifikasiBerkas'])->name('admin.pengajuan.verifikasi.submit');

//Penerbitan Invoice
Route::get('/admin/invoice/create/{pengajuan}', [AdminInvoiceController::class, 'create'])->name('admin.invoice.create');
Route::post('/admin/invoice/store/{pengajuan}', [AdminInvoiceController::class, 'store'])->name('admin.invoice.store');

//Melihat Invoice dan Upload Buti Bayar
Route::get('/dosen/invoice/{pengajuan}', [DosenInvoiceController::class, 'show'])->name('dosen.invoice.show');
Route::post('/dosen/invoice/{pengajuan}/upload', [DosenInvoiceController::class, 'uploadBukti'])->name('dosen.invoice.upload');
    //PDF Invoice
    Route::prefix('dosen')->middleware(['auth'])->group(function () {
        Route::get('/dosen/invoice/{id}/cetak', [DosenInvoiceController::class, 'cetakPDF'])->name('dosen.invoice.cetak');
    });

// Daftar invoice menunggu verifikasi
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/invoice/verifikasi', [AdminInvoiceController::class, 'verifikasiIndex'])->name('admin.invoice.verifikasi.index');
    Route::get('/invoice/verifikasi/{id}', [AdminInvoiceController::class, 'verifikasiShow'])->name('admin.invoice.verifikasi.show');
    Route::post('/invoice/verifikasi/{id}', [AdminInvoiceController::class, 'verifikasiSimpan'])->name('admin.invoice.verifikasi.store');
});

// Cetak Kuitansi
Route::get('/pengajuan/{id}/kuitansi', [DosenInvoiceController::class, 'cetakKuitansi'])->name('dosen.kuitansi.cetak');

//Cetak Surat Keterangan dan Sertif
Route::get('/dosen/pengajuan/{pengajuan}/surat', [DosenSuratController::class, 'cetakSurat'])->name('dosen.pengajuan.surat');
Route::get('/dosen/pengajuan/{pengajuan}/sertifikat', [DosenSuratController::class, 'cetakSertifikat'])->name('dosen.pengajuan.sertifikat');

//Download Sertifikat
Route::get('/dosen/pengajuan/{pengajuan}/sertifikat/download', [SertifikatController::class, 'downloadZip'])->name('dosen.sertifikat.download');

//PELATIHAN LUAR
    //CRUD MASTER
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::resource('unit', UnitController::class);
        Route::resource('jabatan', JabatanController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('jabatan', JabatanController::class)->except(['show']);
        Route::resource('pegawai', PegawaiController::class)->except(['show']);
    });

    //CREATE USER PEGAWAI
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/buat-user-pegawai', [PegawaiUserController::class, 'create'])->name('pegawaiuser.create');
        Route::post('/buat-user-pegawai', [PegawaiUserController::class, 'store'])->name('pegawaiuser.store');
    });
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::post('/pegawai/{pegawai}/buat-user', [PegawaiUserController::class, 'createUser'])->name('pegawaiuser.createUser');
    });

    //INPUT PELATIHAN
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('pelatihan', AdminPelatihanController::class);
        Route::delete('/pelatihan/{pelatihan}', [AdminPelatihanController::class, 'destroy'])->name('pelatihan.destroy');

    });

    //CETAK SURAT TUGAS
    Route::get('/pegawai/pelatihan/{pelatihan}/surat-tugas', [PegawaiPelatihanController::class, 'cetakSuratTugas'])->name('pegawai.pelatihan.surat');

    //INPUT LAPORAN PELATIHAN OLEH PEGAWAI
    Route::middleware(['auth'])->prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('pelatihan/{pelatihan}/laporan', [PegawaiLaporanController::class, 'create'])->name('laporan.create');
        Route::post('pelatihan/{pelatihan}/laporan', [PegawaiLaporanController::class, 'store'])->name('laporan.store');
        Route::get('/laporan/{laporan}', [PegawaiLaporanController::class, 'show'])->name('laporan.show');
        Route::get('laporan/{laporan}/edit', [PegawaiLaporanController::class, 'edit'])->name('laporan.edit');
        Route::put('laporan/{laporan}', [PegawaiLaporanController::class, 'update'])->name('laporan.update');
    });

    //VERIFIKASI MANAJER
    Route::middleware(['auth'])->prefix('manajer')->name('manajer.')->group(function () {
        Route::get('/laporan', [ManajerLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/{laporan}', [ManajerLaporanController::class, 'show'])->name('laporan.show');
        Route::post('/laporan/{laporan}/verifikasi', [ManajerLaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
    });

    //IHT
    Route::middleware(['auth'])->prefix('admin/iht')->name('admin.iht.')->group(function () {
        Route::get('/iht', [AdminIhtController::class, 'index'])->name('index');
        Route::get('/create', [AdminIhtController::class, 'create'])->name('create');
        Route::post('/store', [AdminIhtController::class, 'store'])->name('store');
        Route::get('/{iht}/edit', [AdminIhtController::class, 'edit'])->name('edit');
        Route::put('/{iht}', [AdminIhtController::class, 'update'])->name('update');
        Route::delete('/{iht}', [AdminIhtController::class, 'destroy'])->name('destroy');
        Route::get('/{iht}/peserta', [AdminIhtController::class, 'peserta'])->name('peserta');
        Route::post('/{iht}/peserta/tambah', [AdminIhtController::class, 'tambahPeserta'])->name('peserta.tambah');
        Route::delete('/{iht}/peserta/{participant_id}', [AdminIhtController::class, 'hapusPeserta'])->name('peserta.hapus');
        Route::get('/admin/iht/{iht}/presensi', [AdminIhtController::class, 'presensi'])->name('presensi');
        Route::post('/admin/iht/{iht}/presensi', [AdminIhtController::class, 'simpanPresensi'])->name('presensi.simpan');
        Route::get('/admin/iht/{id}/generate-sertifikat', [AdminIhtController::class, 'generateSertifikat'])->name('generate-sertifikat');
    });

    //VIEW IHT PEGAWAI
    Route::middleware(['auth'])->prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/iht', [PegawaiIhtController::class, 'index'])->name('iht.index');
        Route::get('/iht/evaluasi/{participant}', [PegawaiIhtController::class, 'evaluasiForm'])->name('iht.evaluasi');
        Route::post('/iht/evaluasi/{participant}', [PegawaiIhtController::class, 'submitEvaluasi'])->name('iht.evaluasi.submit');
    });

    //LAPORAN
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/laporan/magang', [AdminLaporanController::class, 'magang'])->name('admin.laporan.magang');
        Route::get('/laporan/pelatihan', [AdminLaporanController::class, 'pelatihan'])->name('admin.laporan.pelatihan');
        Route::get('/laporan/iht', [AdminLaporanController::class, 'iht'])->name('admin.laporan.iht');

        // Export
        Route::get('/laporan/magang/export', [AdminLaporanController::class, 'exportMagang'])->name('admin.laporan.magang.export');
        Route::get('/laporan/pelatihan/export', [AdminLaporanController::class, 'exportPelatihan'])->name('admin.laporan.pelatihan.export');
        Route::get('/laporan/iht/export', [AdminLaporanController::class, 'exportIht'])->name('admin.laporan.iht.export');
    });

require __DIR__.'/auth.php';
