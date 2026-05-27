<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS ini buat nyembunyiin tombol pas kertasnya di-print */
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-light p-5">

<div class="container d-flex justify-content-center">
    <div class="card shadow border-0" style="width: 100%; max-width: 600px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h4 class="fw-bold">PERPUSTAKAAN DIGITAL</h4>
                <p class="text-muted small">Bukti Pengajuan Peminjaman Buku</p>
                <hr>
            </div>

            <table class="table table-borderless table-sm">
                <tr>
                    <td width="35%" class="fw-semibold">Kode Peminjaman</td>
                    <td>: #PMJ-{{ $data->PeminjamanID }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold">Nama Peminjam</td>
                    <td>: {{ $data->user->NamaLengkap }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold">Judul Buku</td>
                    <td>: <strong>{{ $data->buku->Judul }}</strong></td>
                </tr>
                <tr>
                    <td class="fw-semibold">Tanggal Pinjam</td>
                    <td>: {{ $data->TanggalPeminjaman }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold">Tenggat Kembali</td>
                    <td>: {{ $data->TanggalPengembalian }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold">Status Saat Ini</td>
                    <td>: <span class="badge bg-warning text-dark">{{ $data->StatusPeminjaman }}</span></td>
                </tr>
            </table>

            <div class="alert alert-info mt-4 small text-center">
                Silakan tunjukkan bukti ini kepada petugas perpustakaan untuk mengambil buku fisik Anda.
            </div>

            <div class="text-center mt-4 no-print">
                <button onclick="window.print()" class="btn btn-dark btn-sm me-2">🖨️ Cetak Struk</button>
                <a href="{{ url('/user/katalog') }}" class="btn btn-secondary btn-sm">Kembali ke Katalog</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>