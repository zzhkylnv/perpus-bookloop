<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'BukuID';
    
    // Ini dia kunci rahasianya! Kita buka gembok untuk semua variasi huruf stok
    protected $fillable = [
        'Judul', 
        'Penulis', 
        'Penerbit', 
        'TahunTerbit', 
        'Stok',
        'stok'
    ];

    public function kategoris()
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategoribuku_relasi', 'BukuID', 'KategoriID');
    }
}