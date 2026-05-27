@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0" style="color: #1E1E1E;">Kelola Kategori</h4>
            <p class="text-muted small m-0">Pengorganisasian rak buku digital lebih rapi. ✨</p>
        </div>
        <button class="btn btn-sm text-white fw-semibold px-3 py-2" data-bs-toggle="modal" data-bs-target="#addModal" style="background-color: #FF6B00; border-radius: 8px;">
            <i class="fa-solid fa-plus me-1"></i> Tambah Kategori
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-light rounded-circle me-3 text-warning"><i class="fa-solid fa-folder fa-lg"></i></div>
                    <div><p class="text-muted small mb-0">Total Kategori</p><h3 class="fw-bold m-0">{{ $kategori->count() }}</h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-light rounded-circle me-3 text-success"><i class="fa-solid fa-circle-check fa-lg"></i></div>
                    <div><p class="text-muted small mb-0">Status Aktif</p><h3 class="fw-bold m-0">{{ $kategori->count() }}</h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-light rounded-circle me-3 text-danger"><i class="fa-solid fa-clock fa-lg"></i></div>
                    <div><p class="text-muted small mb-0">Nonaktif</p><h3 class="fw-bold m-0">0</h3></div>
                </div>
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
                        <th width="5%">No.</th>
                        <th>Nama Kategori</th>
                        <th>Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $key => $item)
                    <tr style="border-bottom: 1px solid #F0F2F5;">
                        <td class="text-muted">{{ $key + 1 }}</td>
                        <td class="fw-bold text-dark">{{ $item->NamaKategori }}</td>
                        <td><span class="badge bg-success-subtle text-success px-2 py-1" style="border-radius: 6px; font-size: 11px;">Aktif</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-sm btn-light border text-secondary px-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->KategoriID }}"><i class="fa-solid fa-eye"></i></button>
                                <button class="btn btn-sm btn-light border text-warning px-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->KategoriID }}"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ url('/admin/kategori/'.$item->KategoriID) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger px-2"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="detailModal{{ $item->KategoriID }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 12px; border: none;">
                                <div class="modal-header border-0 bg-light py-3">
                                    <h6 class="modal-title fw-bold text-dark"><i class="fa-solid fa-eye text-primary me-2"></i>Detail Kategori</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 text-center">
                                    <h1 class="display-4">🏷️</h1>
                                    <h4 class="fw-bold" style="color: #FF6B00;">{{ $item->NamaKategori }}</h4>
                                    <p class="text-muted">Kategori ini digunakan untuk mengelompokkan koleksi buku perpustakaan agar siswa lebih mudah mencari tema yang sesuai.</p>
                                    <hr>
                                    <p class="small text-muted mb-0">ID Kategori: #CAT-{{ $item->KategoriID }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editModal{{ $item->KategoriID }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 12px; border: none;">
                                <div class="modal-header border-0 bg-light py-3">
                                    <h6 class="modal-title fw-bold text-dark">Edit Kategori</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('/admin/kategori/'.$item->KategoriID) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body p-4">
                                        <label class="form-label small fw-bold">Nama Kategori</label>
                                        <input type="text" class="form-control" name="NamaKategori" value="{{ $item->NamaKategori }}" required style="border-radius: 8px;">
                                    </div>
                                    <div class="modal-footer border-0 bg-light">
                                        <button type="submit" class="btn btn-sm text-white px-4" style="background-color: #FF6B00; border-radius: 8px;">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-0 bg-light py-3">
                <h6 class="modal-title fw-bold text-dark">Tambah Kategori Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/kategori') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <label class="form-label small fw-bold">Nama Kategori</label>
                    <input type="text" class="form-control" name="NamaKategori" placeholder="Cth: Sains, Novel" required style="border-radius: 8px;">
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="submit" class="btn btn-sm text-white px-4" style="background-color: #FF6B00; border-radius: 8px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection