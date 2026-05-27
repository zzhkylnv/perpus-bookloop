<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-register { max-width: 500px; margin-top: 50px; border-radius: 12px; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card card-register shadow-sm p-4 bg-white w-100">
        <h3 class="text-center mb-3 fw-bold text-primary">Daftar Akun</h3>
        <p class="text-muted text-center small">Lengkapi data diri untuk menjadi member perpustakaan</p>

        @if ($errors->any())
            <div class="alert alert-danger small p-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="Username" class="form-label small fw-semibold">Username</label>
                    <input type="text" class="form-control" id="Username" name="Username" value="{{ old('Username') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="Email" class="form-label small fw-semibold">Email</label>
                    <input type="email" class="form-control" id="Email" name="Email" value="{{ old('Email') }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label small fw-semibold">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" required placeholder="Minimal 5 karakter">
            </div>
            <div class="mb-3">
                <label for="NamaLengkap" class="form-label small fw-semibold">Nama Lengkap</label>
                <input type="text" class="form-control" id="NamaLengkap" name="NamaLengkap" value="{{ old('NamaLengkap') }}" required>
            </div>
            <div class="mb-3">
                <label for="Alamat" class="form-label small fw-semibold">Alamat Rumah</label>
                <textarea class="form-control" id="Alamat" name="Alamat" rows="3" required>{{ old('Alamat') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Registrasi Sekarang</button>
        </form>

        <div class="text-center mt-3">
            <p class="small text-muted">Sudah punya akun? <a href="{{ url('/login') }}" class="text-decoration-none">Login di sini</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>