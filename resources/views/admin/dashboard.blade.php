@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-white shadow-sm border-0 border-start border-primary border-4 p-3" style="border-radius: 12px;">
            <p class="text-muted small mb-1 fw-bold">TOTAL BUKU</p>
            <h3 class="fw-bold m-0">1.243</h3>
            <span class="text-success small" style="font-size: 11px;"><i class="fa-solid fa-arrow-up"></i> 12 buku baru</span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-white shadow-sm border-0 border-start border-success border-4 p-3" style="border-radius: 12px;">
            <p class="text-muted small mb-1 fw-bold">TOTAL USER</p>
            <h3 class="fw-bold m-0">856</h3>
            <span class="text-primary small" style="font-size: 11px;">25 user baru</span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-white shadow-sm border-0 border-start border-warning border-4 p-3" style="border-radius: 12px;">
            <p class="text-muted small mb-1 fw-bold">PEMINJAMAN AKTIF</p>
            <h3 class="fw-bold m-0">186</h3>
            <span class="text-muted small" style="font-size: 11px;">Sedang dipinjam</span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-white shadow-sm border-0 border-start border-danger border-4 p-3" style="border-radius: 12px;">
            <p class="text-muted small mb-1 fw-bold">PENGEMBALIAN</p>
            <h3 class="fw-bold m-0">28</h3>
            <span class="text-danger small" style="font-size: 11px;"><i class="fa-solid fa-clock"></i> Hari ini</span>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-clock-rotate-left text-secondary"></i> Aktivitas Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle small">
                    <thead>
                        <tr class="text-muted">
                            <th>Nama User</th>
                            <th>Buku</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">Nadia Putri</td>
                            <td>Laskar Pelangi</td>
                            <td>20 Mei 2026</td>
                            <td><span class="badge bg-success px-2 py-1">Dikembalikan</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Andi Setyawan</td>
                            <td>Bumi Manusia</td>
                            <td>20 Mei 2026</td>
                            <td><span class="badge bg-warning text-dark px-2 py-1">Dipinjam</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-print text-secondary"></i> Cetak Laporan</h5>
            <div class="d-grid gap-2">
                <button class="btn btn-outline-dark btn-sm text-start p-2 rounded-3"><i class="fa-solid fa-file-pdf text-danger me-2"></i> Ekspor PDF Data Buku</button>
                <button class="btn btn-outline-dark btn-sm text-start p-2 rounded-3"><i class="fa-solid fa-file-pdf text-danger me-2"></i> Ekspor PDF Aktivitas</button>
                <hr class="my-2">
                <p class="small text-muted mb-1">Aksi Cepat</p>
                <a href="{{ url('/admin/buku') }}" class="btn btn-sm text-white text-center p-2 rounded-3 fw-semibold" style="background-color: #FF6B00;">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Buku Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection