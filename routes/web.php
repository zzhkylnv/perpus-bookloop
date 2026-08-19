<?php

use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $favBooks = \App\Models\Buku::latest()->take(5)->get();
    return view('home', compact('favBooks'));
})->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/katalog', [PeminjamanController::class, 'katalogUser'])->name('catalog.index');


Route::middleware(['auth'])->group(function () {
    
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
    Route::get('/petugas/dashboard', function () { return view('petugas.dashboard'); });
    
    Route::get('/history', [PeminjamanController::class, 'riwayatUser'])->name('history.index');
    Route::get('/profile', function() { return view('user.profile'); })->name('profile.show');

    Route::get('/admin/kategori', [KategoriBukuController::class, 'index']);
    Route::post('/admin/kategori', [KategoriBukuController::class, 'store']);
    Route::put('/admin/kategori/{id}', [KategoriBukuController::class, 'update']);
    Route::delete('/admin/kategori/{id}', [KategoriBukuController::class, 'destroy']);
    
    Route::get('/admin/buku', [BukuController::class, 'index']);
    Route::post('/admin/buku', [BukuController::class, 'store']);
    Route::put('/admin/buku/{id}', [BukuController::class, 'update']);
    Route::delete('/admin/buku/{id}', [BukuController::class, 'destroy']);

    Route::get('/admin/petugas', [PetugasController::class, 'index']);
    Route::post('/admin/petugas', [PetugasController::class, 'store']);
    Route::put('/admin/petugas/{id}', [PetugasController::class, 'update']);
    Route::delete('/admin/petugas/{id}', [PetugasController::class, 'destroy']);

    Route::get('/admin/anggota', [AnggotaController::class, 'index']);
    Route::post('/admin/anggota', [AnggotaController::class, 'store']);
    Route::put('/admin/anggota/{id}', [AnggotaController::class, 'update']);
    Route::delete('/admin/anggota/{id}', [AnggotaController::class, 'destroy']);

    Route::get('/admin/peminjaman', [PeminjamanController::class, 'index']);
    Route::post('/admin/peminjaman', [PeminjamanController::class, 'store']);
    Route::put('/admin/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan']);
    Route::delete('/admin/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
    Route::get('/admin/laporan/cetak', [PeminjamanController::class, 'cetakLaporan']);

    Route::get('/user/katalog', [PeminjamanController::class, 'katalogUser']);
    Route::post('/user/peminjaman', [PeminjamanController::class, 'ajukanPinjam']); // Perbaikan Namespace
    Route::get('/user/riwayat', [PeminjamanController::class, 'riwayatUser']);
    Route::post('/user/pengembalian/{id}', [PeminjamanController::class, 'ajukanKembali']);
    Route::get('/user/peminjaman/bukti/{id}', [PeminjamanController::class, 'cetakBukti']);
    
    Route::post('/user/ulasan', [PeminjamanController::class, 'simpanUlasan']);
});

Route::middleware(['auth'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');

    Route::get('/buku', [PetugasController::class, 'bukuIndex'])->name('petugas.buku.index');
    Route::get('/buku/create', [PetugasController::class, 'bukuCreate'])->name('petugas.buku.create');
    Route::post('/buku/store', [PetugasController::class, 'bukuStore'])->name('petugas.buku.store');
    Route::get('/buku/{id}/edit', [PetugasController::class, 'bukuEdit'])->name('petugas.buku.edit');
    Route::put('/buku/{id}/update', [PetugasController::class, 'bukuUpdate'])->name('petugas.buku.update');
    Route::delete('/buku/{id}/destroy', [PetugasController::class, 'bukuDestroy'])->name('petugas.buku.destroy');

    Route::get('/verifikasi', [PetugasController::class, 'verifikasiIndex'])->name('petugas.verifikasi.index');
    Route::post('/peminjaman/{id}/setuju', [PetugasController::class, 'setujuPinjam'])->name('petugas.pinjam.setuju');
    Route::post('/peminjaman/{id}/tolak', [PetugasController::class, 'tolakPinjam'])->name('petugas.pinjam.tolak');
    Route::post('/pengembalian/{id}/setuju', [PetugasController::class, 'setujuKembali'])->name('petugas.kembali.setuju');

    Route::get('/laporan', [PetugasController::class, 'laporanIndex'])->name('petugas.laporan.index');
    Route::get('/laporan/cetak-buku', [PetugasController::class, 'cetakBuku'])->name('petugas.cetak.buku');
    Route::get('/laporan/cetak-peminjaman', [PetugasController::class, 'cetakPeminjaman'])->name('petugas.cetak.peminjaman');
    Route::get('/laporan/cetak-user', [PetugasController::class, 'cetakUser'])->name('petugas.cetak.user');
});