<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BookLoop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-orange: #FF6B00; --sidebar-dark: #1E1E1E; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #F8F9FA; margin: 0; }
        .sidebar { width: 260px; height: 100vh; position: fixed; background: var(--sidebar-dark); color: white; padding: 20px; z-index: 100; }
        .sidebar .nav-link { color: #A0A0A0; margin: 8px 0; border-radius: 10px; padding: 12px; transition: 0.3s; text-decoration: none; display: block; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: var(--primary-orange); color: white; }
        .sidebar .nav-link i { margin-right: 10px; width: 20px; }
        .main-content { margin-left: 260px; padding: 40px; min-height: 100vh; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-white"><i class="fa-solid fa-book-open" style="color: #FF6B00;"></i> BOOKLOOP</h4>
            <span class="badge bg-warning text-dark small px-3">ADMIN PANEL</span>
            <hr style="border-color: #404040;">
        </div>
       <div class="nav flex-column">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a class="nav-link {{ request()->is('admin/kategori*') ? 'active' : '' }}" href="{{ url('/admin/kategori') }}"><i class="fa-solid fa-tags"></i> Kelola Kategori</a>
            <a class="nav-link {{ request()->is('admin/buku*') ? 'active' : '' }}" href="{{ url('/admin/buku') }}"><i class="fa-solid fa-book"></i> Kelola Buku</a>
            <a class="nav-link {{ request()->is('admin/petugas*') ? 'active' : '' }}" href="{{ url('/admin/petugas') }}"><i class="fa-solid fa-user-shield"></i> Kelola Petugas</a>
            <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{ url('/admin/user') }}"><i class="fa-solid fa-users"></i> Kelola User</a>
            <a class="nav-link {{ request()->is('admin/peminjaman*') ? 'active' : '' }}" href="{{ url('/admin/peminjaman') }}"><i class="fa-solid fa-hand-holding"></i> Peminjaman</a>
            <hr style="border-color: #404040;">
            
            <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start" style="cursor: pointer;">
                    <i class="fa-solid fa-right-from-bracket text-danger"></i> Keluar / Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0" style="color: #1E1E1E;">Dashboard Admin</h2>
                <p class="text-muted small m-0">Kelola perpustakaan dengan mudah dan efisien ✨</p>
            </div>
            <div class="d-flex align-items-center bg-white p-2 px-3 rounded shadow-sm border">
                <i class="fa-solid fa-user-gear fa-2x me-2 text-secondary"></i>
                <div class="small">
                    <div class="fw-bold">Administrator</div>
                    <div class="text-muted" style="font-size: 11px;">Status: Online</div>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>