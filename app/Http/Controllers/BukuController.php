<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategoris')->get();
        $kategori = KategoriBuku::all(); 
        return view('admin.buku.index', compact('buku', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required|max:255',
            'Penulis' => 'required|max:255',
            'Penerbit' => 'required|max:255',
            'TahunTerbit' => 'required|numeric',
            'Stok' => 'required|numeric',
            'KategoriID' => 'required' 
        ]);

        DB::transaction(function () use ($request) {
            $buku = Buku::create([
                'Judul' => $request->Judul,
                'Penulis' => $request->Penulis,
                'Penerbit' => $request->Penerbit,
                'TahunTerbit' => $request->TahunTerbit,
                // INI YANG BIKIN ERROR TADI, SUDAH DIGANTI JADI HURUF KECIL:
                'stok' => $request->Stok, 
            ]);
            
            $buku->kategoris()->attach($request->KategoriID);
        });

        return back()->with('success', 'Buku baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Judul' => 'required|max:255',
            'Penulis' => 'required|max:255',
            'Penerbit' => 'required|max:255',
            'TahunTerbit' => 'required|numeric',
            'Stok' => 'required|numeric',
            'KategoriID' => 'required'
        ]);

        DB::transaction(function () use ($request, $id) {
            $buku = Buku::where('BukuID', $id)->firstOrFail();
            
            $buku->update([
                'Judul' => $request->Judul,
                'Penulis' => $request->Penulis,
                'Penerbit' => $request->Penerbit,
                'TahunTerbit' => $request->TahunTerbit,
                // INI JUGA SUDAH DIGANTI JADI HURUF KECIL:
                'stok' => $request->Stok,
            ]);
            
            $buku->kategoris()->sync($request->KategoriID);
        });

        return back()->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::where('BukuID', $id)->firstOrFail();
        $buku->delete(); 
        
        return back()->with('success', 'Buku berhasil dihapus!');
    }
}