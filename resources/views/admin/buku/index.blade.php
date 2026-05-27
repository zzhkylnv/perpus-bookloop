@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0" style="color: #1E1E1E;">Kelola Koleksi Buku</h4>
            <p class="text-muted small m-0">Pantau dan kelola seluruh koleksi fisik perpustakaan. 📚</p>
        </div>
        <button class="btn btn-sm text-white fw-semibold px-3 py-2" data-bs-toggle="modal" data-bs-target="#addBukuModal" style="background-color: #FF6B00; border-radius: 8px;">
            <i class="fa-solid fa-plus me-1"></i> Tambah Buku Baru
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <p class="text-muted small mb-1 fw-bold">TOTAL JUDUL</p>
                <h4 class="fw-bold m-0" style="color: #1E1E1E;">{{ $buku->count() }}</h4>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <p class="text-muted small mb-1 fw-bold">TOTAL STOK FISIK</p>
                <h4 class="fw-bold m-0 text-success">{{ $buku->sum('Stok') + $buku->sum('stok') }} <span class="small text-muted" style="font-size: 12px;">Buku</span></h4>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <p class="text-muted small mb-1 fw-bold">DIPINJAM</p>
                <h4 class="fw-bold m-0 text-primary">0 <span class="small text-muted" style="font-size: 12px;">Buku</span></h4>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <p class="text-muted small mb-1 fw-bold">RUANG PERAWATAN</p>
                <h4 class="fw-bold m-0 text-danger">0 <span class="small text-muted" style="font-size: 12px;">Buku</span></h4>
            </div>
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
                        <th width="5%">Sampul</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Stok</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $item)
                    <tr style="border-bottom: 1px solid #F0F2F5;">
                        <td>
                            <div class="bg-light rounded p-2 text-center" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-book text-secondary fa-lg"></i>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block mb-0">{{ $item->Judul }}</span>
                            <small class="text-muted">Tahun Terbit: {{ $item->TahunTerbit }}</small>
                        </td>
                        <td class="text-dark fw-medium">{{ $item->Penulis }}</td>
                        <td class="text-muted">{{ $item->Penerbit }}</td>
                        <td><span class="badge bg-primary-subtle text-primary px-2 py-1" style="font-size: 11px;">{{ $item->Stok ?? $item->stok ?? 0 }} Buku</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-sm btn-light border text-secondary px-2" data-bs-toggle="modal" data-bs-target="#detailBukuModal{{ $item->BukuID }}"><i class="fa-solid fa-eye"></i></button>
                                
                                <button class="btn btn-sm btn-light border text-warning px-2" data-bs-toggle="modal" data-bs-target="#editBukuModal{{ $item->BukuID }}"><i class="fa-solid fa-pen"></i></button>
                                
                                <form action="{{ url('/admin/buku/'.$item->BukuID) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus buku ini dari sistem?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger px-2"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada daftar koleksi buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($buku as $item)
    <div class="modal fade" id="detailBukuModal{{ $item->BukuID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header border-0 bg-light py-3">
                    <h6 class="modal-title fw-bold text-dark"><i class="fa-solid fa-eye text-primary me-2"></i>Informasi Detail Buku</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded d-inline-block p-4 mb-2"><i class="fa-solid fa-book fa-3x text-secondary"></i></div>
                        <h5 class="fw-bold text-dark m-0">{{ $item->Judul }}</h5>
                        <span class="badge bg-success mt-1">Koleksi Aktif</span>
                    </div>
                    <div class="p-3 bg-light rounded-3">
                        <div class="row g-2 small">
                            <div class="col-4 text-muted fw-bold">PENULIS</div>
                            <div class="col-8 text-dark fw-semibold">: {{ $item->Penulis }}</div>
                            <div class="col-4 text-muted fw-bold">PENERBIT</div>
                            <div class="col-8 text-dark fw-semibold">: {{ $item->Penerbit }}</div>
                            <div class="col-4 text-muted fw-bold">TAHUN TERBIT</div>
                            <div class="col-8 text-dark fw-semibold">: {{ $item->TahunTerbit }}</div>
                            <div class="col-4 text-muted fw-bold">STOK TERSEDIA</div>
                            <div class="col-8 text-dark fw-semibold">: {{ $item->Stok ?? $item->stok ?? 0 }} Buku</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBukuModal{{ $item->BukuID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header border-0 bg-light py-3">
                    <h6 class="modal-title fw-bold text-dark"><i class="fa-solid fa-pen text-warning me-2"></i>Edit Data Buku</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/admin/buku/'.$item->BukuID) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Judul Buku</label>
                                <input type="text" class="form-control" name="Judul" value="{{ $item->Judul }}" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Kategori Rak Buku</label>
                                <select class="form-select" name="KategoriID" required style="border-radius: 8px;">
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->KategoriID }}" {{ $item->kategoris->contains($kat->KategoriID) ? 'selected' : '' }}>
                                            {{ $kat->NamaKategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Penulis</label>
                                <input type="text" class="form-control" name="Penulis" value="{{ $item->Penulis }}" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Penerbit</label>
                                <input type="text" class="form-control" name="Penerbit" value="{{ $item->Penerbit }}" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Tahun Terbit</label>
                                <input type="number" class="form-control" name="TahunTerbit" value="{{ $item->TahunTerbit }}" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Stok Buku</label>
                                <input type="number" class="form-control" name="Stok" value="{{ $item->Stok ?? $item->stok ?? 0 }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-light btn-sm border px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm text-white px-4" style="background-color: #FF6B00; border-radius: 8px;">UPDATE DATA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<div class="modal fade" id="addBukuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header border-0 bg-light py-3">
                <h6 class="modal-title fw-bold text-dark"><i class="fa-solid fa-square-plus text-success me-2"></i>Tambah Buku Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/buku') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Judul Buku</label>
                            <input type="text" class="form-control" name="Judul" required placeholder="Masukkan judul buku" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Kategori Rak</label>
                            <select class="form-select" name="KategoriID" required style="border-radius: 8px;">
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->KategoriID }}">{{ $kat->NamaKategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Penulis</label>
                            <input type="text" class="form-control" name="Penulis" required placeholder="Nama penulis" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Penerbit</label>
                            <input type="text" class="form-control" name="Penerbit" required placeholder="Nama penerbit" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Tahun Terbit</label>
                            <input type="number" class="form-control" name="TahunTerbit" required placeholder="Cth: 2026" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Stok</label>
                            <input type="number" class="form-control" name="Stok" required placeholder="Jumlah buku masuk" style="border-radius: 8px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light btn-sm border px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm text-white px-5 fw-bold" style="background-color: #FF6B00; border-radius: 8px;">SIMPAN BUKU</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection