<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;

class PeminjamanController extends Controller
{
    // ==========================================
    // 🛠️ FITUR UNTUK SISI ADMIN & PETUGAS
    // ==========================================

    public function index()
    {
        // Mengambil semua data peminjaman beserta data user dan bukunya
        $peminjaman = Peminjaman::with(['user', 'buku'])->get();
        
        // 🔥 PERBAIKAN BUNG: Mengubah 'peminjam' menjadi 'user' sesuai ENUM database kamu
        $siswas = User::where('role', 'user')->get();
        $bukus = Buku::all();

        return view('peminjaman.index', compact('peminjaman', 'siswas', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'UserID' => 'required',
            'BukuID' => 'required',
            'TanggalPeminjaman' => 'required|date',
            'TanggalPengembalian' => 'required|date',
        ]);

        Peminjaman::create([
            'UserID' => $request->UserID,
            'BukuID' => $request->BukuID,
            'TanggalPeminjaman' => $request->TanggalPeminjaman,
            'TanggalPengembalian' => $request->TanggalPengembalian,
            'StatusPeminjaman' => 'Dipinjam', // Otomatis berstatus dipinjam pas baru dibuat
        ]);

        return back()->with('success', 'Transaksi peminjaman buku berhasil dicatat!');
    }

    // Fitur sakti untuk konfirmasi buku dikembalikan oleh petugas
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'StatusPeminjaman' => 'Dikembalikan'
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return back()->with('success', 'Data transaksi berhasil dihapus!');
    }

    // Fitur Cetak Laporan untuk Penguji UKK
    public function cetakLaporan()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->get();
        return view('peminjaman.cetak', compact('peminjaman'));
    }


    // ==========================================
    // 📚 FITUR SISI USER / SISWA MANDIRI
    // ==========================================

    // 1. Menampilkan Galeri Katalog Buku Interaktif Mewah
    public function katalogUser()
    {
        // Menarik data asli seluruh buku dari database lewat Model Buku
        $books = Buku::latest()->get();
        
        // Melempar data buku ke view user/katalog.blade.php
        return view('user.katalog', compact('books'));
    }

    // 2. Memproses Pengajuan Pinjam Buku dari Tombol Klik Siswa
   public function ajukanPinjam(Request $request)
{
    // 1. Validasi input wajib ada ID Bukunya
    $request->validate([
        'BukuID' => 'required'
    ]);

    // 2. Set otomatis tanggal pinjam hari ini & batas kembali 7 hari ke depan
    $tanggalPinjam = now()->format('Y-m-d');
    $tanggalKembali = now()->addDays(7)->format('Y-m-d');

    // 3. Masukkan data ke tabel peminjaman database kamu
    Peminjaman::create([
        'UserID'            => auth()->user()->UserID, // ID Siswa yang sedang login
        'BukuID'            => $request->BukuID,
        'TanggalPeminjaman' => $tanggalPinjam,
        'TanggalPengembalian'=> $tanggalKembali,
        'StatusPeminjaman'  => 'Dipinjam', // Langsung berstatus Dipinjam biar muncul di Admin/Petugas
    ]);

    // 4. Lempar balik ke halaman dengan pesan sukses
    return back()->with('success', 'Buku berhasil kamu pinjam, Bung! Otomatis masuk daftar riwayat.');
}

    // 3. Menampilkan Halaman Riwayat Pinjaman Khusus Akun Siswa Terkait
    public function riwayatUser()
    {
        // Hanya mengambil data transaksi milik siswa yang sedang aktif login saja
        $peminjaman = Peminjaman::with(['buku'])
            ->where('UserID', auth()->user()->UserID)
            ->latest()
            ->get();

        return view('user.history', compact('peminjaman'));
    }

    // 4. Memproses Aksi Pengembalian Buku dari Sisi Siswa
    public function ajukanKembali($id)
    {
        $peminjaman = Peminjaman::where('PeminjamanID', $id)
            ->where('UserID', auth()->user()->UserID)
            ->firstOrFail();

        $peminjaman->update([
            'StatusPeminjaman' => 'Dikembalikan'
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan! Terima kasih sudah membaca, Bung.');
    }

    // 5. Fitur Cetak Bukti Peminjaman Berbentuk Nota Kecil untuk Siswa
    public function cetakBukti($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'user'])
            ->where('PeminjamanID', $id)
            ->firstOrFail();

        return view('user.cetak_bukti', compact('peminjaman'));
    }
}