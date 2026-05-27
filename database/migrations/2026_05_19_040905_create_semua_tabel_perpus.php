<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel User
        Schema::create('user', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('Username', 255)->unique();
            $table->string('Password', 255);
            $table->string('Email', 255)->unique();
            $table->string('NamaLengkap', 255);
            $table->text('Alamat');
            $table->enum('role', ['admin', 'petugas', 'user'])->default('user');
            $table->timestamps();
        });

        // 2. Tabel Kategori Buku
        Schema::create('kategoribuku', function (Blueprint $table) {
            $table->id('KategoriID');
            $table->string('NamaKategori', 255);
            $table->timestamps();
        });

        // 3. Tabel Buku
        Schema::create('buku', function (Blueprint $table) {
            $table->id('BukuID');
            $table->string('Judul', 255);
            $table->string('Penulis', 255);
            $table->string('Penerbit', 255);
            $table->integer('TahunTerbit');
            $table->timestamps();
        });

        // 4. Tabel Kategori Buku Relasi
        Schema::create('kategoribuku_relasi', function (Blueprint $table) {
            $table->id('KategoriBukuID');
            $table->foreignId('BukuID')->constrained('buku', 'BukuID')->onDelete('cascade');
            $table->foreignId('KategoriID')->constrained('kategoribuku', 'KategoriID')->onDelete('cascade');
            $table->timestamps();
        });

        // 5. Tabel Peminjaman
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('PeminjamanID');
            $table->foreignId('UserID')->constrained('user', 'UserID')->onDelete('cascade');
            $table->foreignId('BukuID')->constrained('buku', 'BukuID')->onDelete('cascade');
            $table->date('TanggalPeminjaman');
            $table->date('TanggalPengembalian');
            $table->string('StatusPeminjaman', 50)->default('Diajukan Pinjam');
            $table->timestamps();
        });

        // 6. Tabel Ulasan Buku
        Schema::create('ulasanbuku', function (Blueprint $table) {
            $table->id('UlasanID');
            $table->foreignId('UserID')->constrained('user', 'UserID')->onDelete('cascade');
            $table->foreignId('BukuID')->constrained('buku', 'BukuID')->onDelete('cascade');
            $table->text('Ulasan');
            $table->integer('Rating');
            $table->timestamps();
        });

        // 7. Tabel Koleksi Pribadi
        Schema::create('koleksipribadi', function (Blueprint $table) {
            $table->id('KoleksiID');
            $table->foreignId('UserID')->constrained('user', 'UserID')->onDelete('cascade');
            $table->foreignId('BukuID')->constrained('buku', 'BukuID')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksipribadi');
        Schema::dropIfExists('ulasanbuku');
        Schema::dropIfExists('peminjaman');
        Schema::dropIfExists('kategoribuku_relasi');
        Schema::dropIfExists('buku');
        Schema::dropIfExists('kategoribuku');
        Schema::dropIfExists('user');
    }
};