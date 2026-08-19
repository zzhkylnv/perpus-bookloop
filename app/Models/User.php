<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    // 1. Beritahu nama tabel kustom kamu
    protected $table = 'user'; 

    // 2. 🔥 BERITAHU LARAVEL KALAU PRIMARY KEY KAMU ADALAH UserID BUKAN 'id' 🔥
    protected $primaryKey = 'UserID'; 

    // 3. Daftarkan kolom yang boleh diisi data
    protected $fillable = [
        'Username',
        'Password',
        'Email',
        'NamaLengkap',
        'Alamat',
        'role',
    ];

    // 4. Beritahu Laravel kalau kolom password kamu berawalan P kapital
    public function getAuthPassword()
    {
        return $this->Password;
    }
}