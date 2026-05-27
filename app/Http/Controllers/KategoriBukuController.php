<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBuku;

class KategoriBukuController extends Controller
{
    // Menampilkan semua kategori buku
    public function index()
    {
        $kategori = KategoriBuku::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'NamaKategori' => 'required|max:255',
        ]);

        KategoriBuku::create([
            'NamaKategori' => $request->NamaKategori
        ]);

        return back()->with('success', 'Kategori buku berhasil ditambahkan!');
    }

    // Mengubah data kategori buku
    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaKategori' => 'required|max:255',
        ]);

        $kategori = KategoriBuku::findOrFail($id);
        $kategori->update([
            'NamaKategori' => $request->NamaKategori
        ]);

        return back()->with('success', 'Kategori buku berhasil diperbarui!');
    }

    // Menghapus kategori buku
    public function destroy($id)
    {
        $kategori = KategoriBuku::findOrFail($id);
        $kategori->delete();

        return back()->with('success', 'Kategori buku berhasil dihapus!');
    }
}