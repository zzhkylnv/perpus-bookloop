<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-login { max-width: 400px; margin-top: 100px; border-radius: 12px; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card card-login shadow-sm p-4 bg-white w-100">
        <h3 class="text-center mb-4 fw-bold text-primary">BOOKLOOP</h3>
        <p class="text-muted text-center small">Silakan masuk ke akun perpustakaan Anda</p>

        @if($errors->has('loginError'))
            <div class="alert alert-danger small p-2">
                {{ $errors->first('loginError') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success small p-2">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="Username" class="form-label small fw-semibold">Username</label>
                <input type="text" class="form-control" id="Username" name="Username" required placeholder="Masukkan username">
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label small fw-semibold">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" required placeholder="Masukkan password">
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2 py-2 fw-semibold">Masuk</button>
        </form>

        <div class="text-center mt-3">
            <p class="small text-muted">Belum punya akun? <a href="{{ url('/register') }}" class="text-decoration-none">Daftar sekarang</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>