<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        <div class="card p-4 shadow-sm">
            <h4>Daftar Pengajuan Peminjaman & Pengembalian Buku</h4>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Peminjam</th><th>Buku</th><th>Status</th><th>Aksi Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $row)
                    <tr>
                        <td>{{ $row->user->Username }}</td>
                        <td>{{ $row->buku->Judul }}</td>
                        <td><span class="badge bg-secondary">{{ $row->StatusPeminjaman }}</span></td>
                        <td>
                            @if($row->StatusPeminjaman == 'Menunggu Konfirmasi')
                                <form action="{{ route('petugas.pinjam.setuju', $row->id) }}" method="POST" style="display:inline;">
                                    @csrf <button class="btn btn-sm btn-success">Setujui Pinjam</button>
                                </form>
                                <form action="{{ route('petugas.pinjam.tolak', $row->id) }}" method="POST" style="display:inline;">
                                    @csrf <button class="btn btn-sm btn-danger">Tolak</button>
                                </form>
                            @elseif($row->StatusPeminjaman == 'Menunggu Pengembalian')
                                <form action="{{ route('petugas.kembali.setuju', $row->id) }}" method="POST" style="display:inline;">
                                    @csrf <button class="btn btn-sm btn-info text-white">Konfirmasi Buku Kembali</button>
                                </form>
                            @else
                                <span class="text-muted">No Action Needed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>