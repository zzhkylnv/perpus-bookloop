<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 text-center">
        <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary mb-4">Kembali</a>
        <div class="card p-5 shadow-sm mx-auto" style="max-width: 500px;">
            <h4>Pusat Cetak Dokumen Laporan</h4>
            <p class="text-muted">Silakan pilih laporan yang ingin diunduh/dicetak:</p>
            <div class="d-grid gap-3 mt-4">
                <a href="{{ route('petugas.cetak.buku') }}" target="_blank" class="btn btn-primary">Cetak Data Seluruh Buku</a>
                <a href="{{ route('petugas.cetak.peminjaman') }}" target="_blank" class="btn btn-success">Cetak Riwayat Peminjaman</a>
            </div>
        </div>
    </div>
</body>
</html>