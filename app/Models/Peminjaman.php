<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'PeminjamanID';
    public $timestamps = false; // Karena di phpMyAdmin kamu ga ada kolom created_at / updated_at

    protected $fillable = [
        'UserID',
        'BukuID',
        'TanggalPeminjaman',
        'TanggalPengembalian',
        'StatusPeminjaman'
    ];

    // Hubungan ke data User/Siswa
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    // Hubungan ke data Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }
}