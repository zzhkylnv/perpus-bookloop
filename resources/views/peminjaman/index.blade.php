@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0" style="color: #1E1E1E;">Transaksi Peminjaman Buku</h4>
            <p class="text-muted small m-0">Catat dan pantau sirkulasi peminjaman serta pengembalian buku perpustakaan. 📝</p>
        </div>
       <div class="d-flex gap-2">
            <a href="{{ url('/admin/laporan/cetak') }}" target="_blank" class="btn btn-sm btn-dark fw-semibold px-3 py-2" style="border-radius: 8px;">
                <i class="fa-solid fa-print me-1"></i> Generate Laporan
            </a>
            
            <button class="btn btn-sm text-white fw-semibold px-3 py-2" data-bs-toggle="modal" data-bs-target="#addPeminjamanModal" style="background-color: #FF6B00; border-radius: 8px;">
                <i class="fa-solid fa-plus me-1"></i> Catat Peminjaman Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm small p-2 mb-3" style="border-radius: 8px;">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle small m-0">
                <thead>
                    <tr class="text-secondary" style="border-bottom: 2px solid #F0F2F5;">
                        <th>Nama Siswa</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th class="text-center">Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $item)
                    <tr style="border-bottom: 1px solid #F0F2F5;">
                        <td><span class="fw-bold text-dark">{{ $item->user->NamaLengkap ?? 'Siswa Terhapus' }}</span></td>
                        <td><span class="text-muted">{{ $item->buku->Judul ?? 'Buku Terhapus' }}</span></td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d M Y') }}</td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d M Y') }}</td>
                        <td class="text-center">
                            @if($item->StatusPeminjaman == 'Dipinjam')
                                <span class="badge bg-light text-warning border border-warning px-2 py-1" style="border-radius: 6px;">Dipinjam</span>
                            @else
                                <span class="badge bg-light text-success border border-success px-2 py-1" style="border-radius: 6px;">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                @if($item->StatusPeminjaman == 'Dipinjam')
                                <form action="{{ url('/admin/peminjaman/kembalikan/'.$item->PeminjamanID) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success text-white px-2" title="Konfirmasi Pengembalian"><i class="fa-solid fa-circle-check"></i> Balikin Buku</button>
                                </form>
                                @endif
                                <form action="{{ url('/admin/peminjaman/'.$item->PeminjamanID) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus riwayat transaksi ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger px-2"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi peminjaman hari ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addPeminjamanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header border-0 bg-light py-3">
                <h6 class="modal-title fw-bold text-dark"><i class="fa-solid fa-book-bookmark text-success me-2"></i>Form Peminjaman Buku</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/peminjaman') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Siswa / Peminjam</label>
                        <select class="form-select" name="UserID" required style="border-radius: 8px;">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->UserID }}">{{ $siswa->NamaLengkap }} (@{{ $siswa->Username }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Buku yang Dipinjam</label>
                        <select class="form-select" name="BukuID" required style="border-radius: 8px;">
                            <option value="">-- Pilih Judul Buku --</option>
                            @foreach($bukus as $buku)
                                <option value="{{ $buku->BukuID }}">{{ $buku->Judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Tanggal Pinjam</label>
                            <input type="date" class="form-control" name="TanggalPeminjaman" value="{{ date('Y-m-d') }}" required style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Tenggat Pengembalian</label>
                            <input type="date" class="form-control" name="TanggalPengembalian" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required style="border-radius: 8px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light btn-sm border px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm text-white px-5 fw-bold" style="background-color: #FF6B00; border-radius: 8px;">SIMPAN TRANSAKSI</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection