<?php

use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;


// Halaman utama (Landing Page Paling Depan)
Route::get('/', function () {
    return view('home');
})->name('home');

// ==========================================
// ROUTE AUTENTIKASI (LOGIN & REGISTER)
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// ROUTE PUBLIK (BISA DIAKSES SEBELUM LOGIN)
// ==========================================
Route::get('/katalog', [PeminjamanController::class, 'katalogUser'])->name('catalog.index');


// ==========================================
// ROUTE PROTECTED (WAJIB LOGIN DULU)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Masing-Masing Role
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
    Route::get('/petugas/dashboard', function () { return view('petugas.dashboard'); });
    
    // Dashboard / Home Siswa (Mengambil 5 buku terbaru dari database)
    Route::get('/dashboard', function () {
        $favBooks = \App\Models\Buku::latest()->take(5)->get();
        return view('user.dashboard', compact('favBooks'));
    })->name('dashboard');

    // History & Profile Terkunci Hak Akses Auth
    Route::get('/history', [PeminjamanController::class, 'riwayatUser'])->name('history.index');
    Route::get('/profile', function() { return view('user.profile'); })->name('profile.show');

    // ------------------------------------------
    // Route CRUD Kategori Buku (Admin)
    // ------------------------------------------
    Route::get('/admin/kategori', [KategoriBukuController::class, 'index']);
    Route::post('/admin/kategori', [KategoriBukuController::class, 'store']);
    Route::put('/admin/kategori/{id}', [KategoriBukuController::class, 'update']);
    Route::delete('/admin/kategori/{id}', [KategoriBukuController::class, 'destroy']);
    
    // ------------------------------------------
    // Route CRUD Buku (Admin)
    // ------------------------------------------
    Route::get('/admin/buku', [BukuController::class, 'index']);
    Route::post('/admin/buku', [BukuController::class, 'store']);
    Route::put('/admin/buku/{id}', [BukuController::class, 'update']);
    Route::delete('/admin/buku/{id}', [BukuController::class, 'destroy']);

    // ------------------------------------------
    // Route Manajemen Petugas (Admin Only)
    // ------------------------------------------
    Route::get('/admin/petugas', [PetugasController::class, 'index']);
    Route::post('/admin/petugas', [PetugasController::class, 'store']);
    Route::put('/admin/petugas/{id}', [PetugasController::class, 'update']);
    Route::delete('/admin/petugas/{id}', [PetugasController::class, 'destroy']);

    // ------------------------------------------
    // Route Manajemen Anggota / Siswa (Admin)
    // ------------------------------------------
    Route::get('/admin/anggota', [AnggotaController::class, 'index']);
    Route::post('/admin/anggota', [AnggotaController::class, 'store']);
    Route::put('/admin/anggota/{id}', [AnggotaController::class, 'update']);
    Route::delete('/admin/anggota/{id}', [AnggotaController::class, 'destroy']);

    // ------------------------------------------
    // Route Transaksi Peminjaman Buku (Sisi Admin)
    // ------------------------------------------
    Route::get('/admin/peminjaman', [PeminjamanController::class, 'index']);
    Route::post('/admin/peminjaman', [PeminjamanController::class, 'store']);
    Route::put('/admin/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan']);
    Route::delete('/admin/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
    Route::get('/admin/laporan/cetak', [PeminjamanController::class, 'cetakLaporan']);

    // ------------------------------------------
    // Route Transaksi Peminjaman (Sisi User Mandiri)
    // ------------------------------------------
    Route::get('/user/katalog', [PeminjamanController::class, 'katalogUser']);
    Route::post('/user/peminjaman', [PeminjamanController::class, 'ajukanPinjam']); // Perbaikan Namespace
    Route::get('/user/riwayat', [PeminjamanController::class, 'riwayatUser']);
    Route::post('/user/pengembalian/{id}', [PeminjamanController::class, 'ajukanKembali']);
    Route::get('/user/peminjaman/bukti/{id}', [PeminjamanController::class, 'cetakBukti']);
    
    // 🔥 FITUR PENILAIAN UKK: Route Penampung Ulasan Bintang Siswa
    Route::post('/user/ulasan', [PeminjamanController::class, 'simpanUlasan']);
});

//ptugas

Route::middleware(['auth'])->prefix('petugas')->group(function () {
    // Dashboard Utama Petugas
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');

    // 1. Kelola Buku (CRUD)
    Route::get('/buku', [PetugasController::class, 'bukuIndex'])->name('petugas.buku.index');
    Route::get('/buku/create', [PetugasController::class, 'bukuCreate'])->name('petugas.buku.create');
    Route::post('/buku/store', [PetugasController::class, 'bukuStore'])->name('petugas.buku.store');
    Route::get('/buku/{id}/edit', [PetugasController::class, 'bukuEdit'])->name('petugas.buku.edit');
    Route::put('/buku/{id}/update', [PetugasController::class, 'bukuUpdate'])->name('petugas.buku.update');
    Route::delete('/buku/{id}/destroy', [PetugasController::class, 'bukuDestroy'])->name('petugas.buku.destroy');

    // 2. Approval Peminjaman & Pengembalian
    Route::get('/verifikasi', [PetugasController::class, 'verifikasiIndex'])->name('petugas.verifikasi.index');
    Route::post('/peminjaman/{id}/setuju', [PetugasController::class, 'setujuPinjam'])->name('petugas.pinjam.setuju');
    Route::post('/peminjaman/{id}/tolak', [PetugasController::class, 'tolakPinjam'])->name('petugas.pinjam.tolak');
    Route::post('/pengembalian/{id}/setuju', [PetugasController::class, 'setujuKembali'])->name('petugas.kembali.setuju');

    // 3. Generate Laporan
    Route::get('/laporan', [PetugasController::class, 'laporanIndex'])->name('petugas.laporan.index');
    Route::get('/laporan/cetak-buku', [PetugasController::class, 'cetakBuku'])->name('petugas.cetak.buku');
    Route::get('/laporan/cetak-peminjaman', [PetugasController::class, 'cetakPeminjaman'])->name('petugas.cetak.peminjaman');
    Route::get('/laporan/cetak-user', [PetugasController::class, 'cetakUser'])->name('petugas.cetak.user');
});