<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan Bookloop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; background-color: #fff; }
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 30px; }
        table th { background-color: #f2f2f2 !important; color: #000 !important; font-weight: bold; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container my-4">
        <div class="no-print mb-4">
            <button onclick="window.history.back()" class="btn btn-sm btn-secondary">← Kembali ke Aplikasi</button>
            <button onclick="window.print()" class="btn btn-sm btn-primary">🖨️ Cetak / Save PDF</button>
        </div>

        <div class="text-center kop-surat">
            <h2 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px;">PERPUSTAKAAN DIGITAL "BOOKLOOP"</h2>
            <p class="m-0 small text-muted">Gedung Pusat Belajar Siswa, Lantai 1 • Email: support@bookloop.com</p>
            <h5 class="fw-bold mt-3 text-decoration-underline text-uppercase">LAPORAN SIRKULASI PEMINJAMAN BUKU</h5>
        </div>

        <table class="table table-bordered align-middle small">
            <thead>
                <tr class="text-center">
                    <th width="5%">No</th>
                    <th>Nama Anggota / Siswa</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($peminjaman as $item)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>{{ $item->user->NamaLengkap ?? 'N/A' }}</strong> ({{ $item->user->Username ?? '-' }})</td>
                    <td>{{ $item->buku->Judul ?? 'N/A' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        {{ $item->StatusPeminjaman }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-3 text-muted">Belum ada data transaksi sirkulasi buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="row mt-5 pt-4">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-0">Mengetahui,</p>
                <p class="fw-bold">Kepala Perpustakaan Bookloop</p>
                <div style="height: 80px;"></div>
                <p class="text-decoration-underline fw-bold m-0">..........................................</p>
                <p class="text-muted small">NIP. -</p>
            </div>
        </div>
    </div>

</body>
</html>