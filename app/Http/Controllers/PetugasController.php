<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class PetugasController extends Controller
{
    public function index() {
        $totalBuku = Buku::count();
        $totalPendingPinjam = Peminjaman::where('StatusPeminjaman', 'Menunggu Konfirmasi')->count();
        $totalPendingKembali = Peminjaman::where('StatusPeminjaman', 'Menunggu Pengembalian')->count();
        return view('petugas.dashboard', compact('totalBuku', 'totalPendingPinjam', 'totalPendingKembali'));
    }

    public function bukuIndex() {
        $buku = Buku::all();
        return view('petugas.buku.index', compact('buku'));
    }

    public function bukuCreate() { return view('petugas.buku.create'); }

    public function bukuStore(Request $request) {
        $request->validate(['Judul' => 'required', 'Penulis' => 'required', 'Penerbit' => 'required', 'TahunTerbit' => 'required|numeric']);
        Buku::create($request->all());
        return redirect()->route('petugas.buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function verifikasiIndex() {
        $peminjaman = Peminjaman::with(['user', 'buku'])->orderBy('id', 'desc')->get();
        return view('petugas.verifikasi.index', compact('peminjaman'));
    }

    public function setujuPinjam($id) {
        $data = Peminjaman::findOrFail($id);
        if ($data->StatusPeminjaman !== 'Menunggu Konfirmasi') return back()->with('info', 'Sudah diproses!');
        $data->update(['StatusPeminjaman' => 'Dipinjam']);
        return back()->with('success', 'Peminjaman disetujui!');
    }

    public function tolakPinjam($id) {
        $data = Peminjaman::findOrFail($id);
        if ($data->StatusPeminjaman !== 'Menunggu Konfirmasi') return back()->with('info', 'Sudah diproses!');
        $data->update(['StatusPeminjaman' => 'Ditolak']);
        return back()->with('success', 'Peminjaman ditolak!');
    }

    public function setujuKembali($id) {
        $data = Peminjaman::findOrFail($id);
        if ($data->StatusPeminjaman !== 'Menunggu Pengembalian') return back()->with('info', 'Sudah diproses!');
        $data->update(['StatusPeminjaman' => 'Sudah Dikembalikan']);
        return back()->with('success', 'Pengembalian sukses!');
    }

    public function laporanIndex() { return view('petugas.laporan.index'); }

    public function cetakBuku() {
        $buku = Buku::all();
        return view('petugas.laporan.cetak_buku', compact('buku'));
    }

    public function cetakPeminjaman() {
        $peminjaman = Peminjaman::with(['user', 'buku'])->get();
        return view('petugas.laporan.cetak_peminjaman', compact('peminjaman'));
    }
}