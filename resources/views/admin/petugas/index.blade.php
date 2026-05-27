@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0" style="color: #1E1E1E;">Kelola Staf & Petugas</h4>
            <p class="text-muted small m-0">Manajemen akun pengguna untuk menjaga keamanan data perpustakaan. 🔑</p>
        </div>
        <button class="btn btn-sm text-white fw-semibold px-3 py-2" data-bs-toggle="modal" data-bs-target="#addPetugasModal" style="background-color: #FF6B00; border-radius: 8px;">
            <i class="fa-solid fa-user-plus me-1"></i> Tambah Staf Baru
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-12 mb-2">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-light rounded-circle me-3 text-warning"><i class="fa-solid fa-users-gear fa-lg"></i></div>
                    <div>
                        <p class="text-muted small mb-0">Total Staf Terdaftar</p>
                        <h3 class="fw-bold m-0" style="color: #1E1E1E;">{{ $petugas->count() }}</h3>
                    </div>
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
                        <th width="5%">Avatar</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Alamat Email</th>
                        <th>Role</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($petugas as $item)
                    <tr style="border-bottom: 1px solid #F0F2F5;">
                        <td>
                            <div class="bg-light rounded-circle text-center fw-bold text-secondary" style="width: 40px; height: 40px; line-height: 40px; font-size: 14px;">
                                {{ strtoupper(substr($item->NamaLengkap ?? 'US', 0, 2)) }}
                            </div>
                        </td>
                        <td><span class="fw-bold text-dark d-block">{{ $item->NamaLengkap }}</span></td>
                        <td class="text-muted">@<span>{{ $item->Username }}</span></td>
                        <td class="text-muted">{{ $item->Email }}</td>
                        <td>
                            <span class="badge {{ $item->role == 'admin' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }} px-2 py-1" style="font-size: 11px;">
                                {{ strtoupper($item->role) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-sm btn-light border text-secondary px-2" data-bs-toggle="modal" data-bs-target="#detailPetugasModal{{ $item->UserID }}"><i class="fa-solid fa-eye"></i></button>
                                <button class="btn btn-sm btn-light border text-warning px-2" data-bs-toggle="modal" data-bs-target="#editPetugasModal{{ $item->UserID }}"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ url('/admin/petugas/'.$item->UserID) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger px-2"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada akun petugas yang terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($petugas as $item)
    <div class="modal fade" id="detailPetugasModal{{ $item->UserID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header border-0 bg-light py-3">
                    <h6 class="modal-title fw-bold text-dark"><i class="fa-solid fa-id-card text-primary me-2"></i>Profil Detail Akun</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-light text-secondary rounded-circle d-inline-block fw-bold mb-2" style="width: 70px; height: 70px; line-height: 70px; font-size: 24px;">
                            {{ strtoupper(substr($item->NamaLengkap ?? 'US', 0, 2)) }}
                        </div>
                        <h5 class="fw-bold text-dark m-0">{{ $item->NamaLengkap }}</h5>
                        <small class="text-muted">@<span>{{ $item->Username }}</span></small>
                    </div>
                    <div class="p-3 bg-light rounded-3">
                        <div class="row g-2 small">
                            <div class="col-4 text-muted fw-bold">EMAIL ADDRESS</div>
                            <div class="col-8 text-dark fw-semibold">: {{ $item->Email }}</div>
                            <div class="col-4 text-muted fw-bold">ROLE AKSES</div>
                            <div class="col-8 text-dark fw-semibold">: {{ strtoupper($item->role) }}</div>
                            <div class="col-4 text-muted fw-bold">ID SISTEM</div>
                            <div class="col-8 text-dark fw-semibold">: #USR-00{{ $item->UserID }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPetugasModal{{ $item->UserID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header border-0 bg-light py-3">
                    <h6 class="modal-title fw-bold text-dark"><i class="fa-solid fa-user-pen text-warning me-2"></i>Ubah Informasi Akun</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/admin/petugas/'.$item->UserID) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                                <input type="text" class="form-control" name="NamaLengkap" value="{{ $item->NamaLengkap }}" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Role Akses</label>
                                <select class="form-select" name="role" required style="border-radius: 8px;">
                                    <option value="petugas" {{ $item->role == 'petugas' ? 'selected' : '' }}>Petugas Lapangan</option>
                                    <option value="admin" {{ $item->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Username</label>
                                <input type="text" class="form-control" name="Username" value="{{ $item->Username }}" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Alamat Email</label>
                                <input type="email" class="form-control" name="Email" value="{{ $item->Email }}" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-12">
                                <div class="p-3 rounded-3" style="background-color: #FFF8F3; border: 1px dashed #FFD0B0;">
                                    <label class="form-label small fw-bold text-dark mb-1">Ganti Password (Opsional)</label>
                                    <input type="password" class="form-control bg-white" name="Password" placeholder="Kosongkan jika tidak ingin mengubah password" style="border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-light btn-sm border px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm text-white px-4" style="background-color: #FF6B00; border-radius: 8px;">SIMPAN PERUBAHAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<div class="modal fade" id="addPetugasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header border-0 bg-light py-3">
                <h6 class="modal-title fw-bold text-dark"><i class="fa-solid fa-user-plus text-success me-2"></i>Pendaftaran Akun Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/petugas') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <input type="text" class="form-control" name="NamaLengkap" required placeholder="Masukkan nama" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Role Akses</label>
                            <select class="form-select" name="role" required style="border-radius: 8px;">
                                <option value="" disabled selected>-- Pilih Hak Akses --</option>
                                <option value="petugas">Petugas Lapangan</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Username</label>
                            <input type="text" class="form-control" name="Username" required placeholder="Masukkan username" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Alamat Email Aktif</label>
                            <input type="email" class="form-control" name="Email" required placeholder="contoh@email.com" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label small fw-bold text-secondary">Kata Sandi (Password)</label>
                            <input type="password" class="form-control" name="Password" required placeholder="Minimal 6 karakter" style="border-radius: 8px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light btn-sm border px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm text-white px-5 fw-bold" style="background-color: #FF6B00; border-radius: 8px;">DAFTARKAN AKUN</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection