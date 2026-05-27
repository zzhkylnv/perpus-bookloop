<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-between mb-4">
            <h2>Panel Operasional Petugas Perpus</h2>
            <a href="/logout" class="btn btn-danger">Log Out</a>
        </div>
        <div class="mb-4">
            <a href="{{ route('petugas.buku.index') }}" class="btn btn-primary me-2">Kelola Buku</a>
            <a href="{{ route('petugas.verifikasi.index') }}" class="btn btn-warning me-2">Verifikasi Peminjaman</a>
            <a href="{{ route('petugas.laporan.index') }}" class="btn btn-success">Cetak Laporan</a>
        </div>
        <div class="row text-center">
            <div class="col-md-4"><div class="card p-4 bg-white shadow-sm"><h3>{{ $totalBuku }}</h3><p>Total Koleksi Buku</p></div></div>
            <div class="col-md-4"><div class="card p-4 bg-white shadow-sm"><h3>{{ $totalPendingPinjam }}</h3><p>Butuh Approval Pinjam</p></div></div>
            <div class="col-md-4"><div class="card p-4 bg-white shadow-sm"><h3>{{ $totalPendingKembali }}</h3><p>Butuh Approval Kembali</p></div></div>
        </div>
    </div>
</body>
</html>