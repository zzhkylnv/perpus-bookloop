@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0" style="color: #1E1E1E;">Kelola Data Anggota Perpustakaan</h4>
            <p class="text-muted small m-0">Manajemen data siswa / peminjam aktif perpustakaan Bookloop. 📚</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12 mb-2">
            <div class="card bg-white shadow-sm border-0 p-3" style="border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-light rounded-circle me-3 text-success"><i class="fa-solid fa-graduation-cap fa-lg"></i></div>
                    <div>
                        <p class="text-muted small mb-0">Total Anggota (Siswa)</p>
                        <h3 class="fw-bold m-0" style="color: #1E1E1E;">{{ $users->count() }} Orang</h3>
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
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat Email</th>
                        <th>Alamat Rumah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $item)
                    <tr style="border-bottom: 1px solid #F0F2F5;">
                        <td>
                            <div class="bg-light rounded-circle text-center fw-bold text-secondary" style="width: 40px; height: 40px; line-height: 40px; font-size: 14px;">
                                {{ strtoupper(substr($item->NamaLengkap ?? 'AG', 0, 2)) }}
                            </div>
                        </td>
                        <td class="text-muted">@<span>{{ $item->Username }}</span></td>
                        <td><span class="fw-bold text-dark d-block">{{ $item->NamaLengkap }}</span></td>
                        <td class="text-muted">{{ $item->Email }}</td>
                        <td class="text-muted">{{ $item->Alamat }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data siswa/anggota yang terdaftar di sistem.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection