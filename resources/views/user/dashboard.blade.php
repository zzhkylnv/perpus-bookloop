@extends('layouts.app')

@section('title', 'Dashboard – BookLoop')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    :root {
        --navy:      #1E2235;
        --navy-soft: #2A304A;
        --cream:     #F5F2ED;
        --amber:     #C8702A;
        --amber-lt:  #F0A96A;
        --amber-pale:#FDF3EB;
        --text:      #1E2235;
        --muted:     #7B7F96;
        --white:     #FFFFFF;
        --border:    rgba(30,34,53,.10);
        --shadow-sm: 0 2px 12px rgba(30,34,53,.07);
        --shadow-md: 0 8px 32px rgba(30,34,53,.12);
        --r-sm:      8px;
        --r-md:      14px;
        --r-lg:      20px;
        --r-xl:      28px;
        --ff-display: 'Playfair Display', Georgia, serif;
        --ff-body:    'DM Sans', system-ui, sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; }
    body {
        font-family: var(--ff-body);
        background: var(--cream);
        color: var(--text);
        min-height: 100vh;
        overflow-x: hidden;
    }

    .bl-navbar {
        background: var(--navy);
        padding: 0 2rem;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 20px rgba(0,0,0,.25);
    }
    .bl-logo {
        font-family: var(--ff-display);
        font-size: 1.45rem;
        color: var(--white);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .bl-logo span { color: var(--amber-lt); }
    .bl-nav-links { display: flex; gap: 2rem; list-style: none; margin: 0; padding: 0; }
    .bl-nav-links a {
        color: rgba(255,255,255,.65);
        text-decoration: none;
        font-size: .9rem;
        font-weight: 500;
        padding-bottom: 4px;
        border-bottom: 2px solid transparent;
        transition: all .25s;
    }
    .bl-nav-links a:hover, .bl-nav-links a.active {
        color: var(--white);
        border-color: var(--amber-lt);
    }
    .bl-nav-right { display: flex; align-items: center; gap: 1rem; }
    .bl-avatar {
        width: 40px; height: 40px;
        border-radius: 50%;
        border: 2px solid var(--amber-lt);
        object-fit: cover;
        cursor: pointer;
    }

    .bl-hero {
        background: var(--navy);
        padding: 3rem 2rem 5.5rem;
        position: relative;
        overflow: hidden;
    }
    .bl-hero-inner { max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }
    .bl-greeting { font-size: .85rem; color: var(--amber-lt); font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: .5rem; }
    .bl-welcome-title { font-family: var(--ff-display); font-size: clamp(1.9rem, 4vw, 2.8rem); color: var(--white); line-height: 1.2; margin-bottom: .75rem; }
    .bl-welcome-title em { color: var(--amber-lt); font-style: normal; }
    .bl-hero-sub { color: rgba(255,255,255,.55); font-size: .95rem; }

    .bl-stats-row {
        max-width: 1200px;
        margin: -56px auto 0;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        position: relative;
        z-index: 10;
    }
    .bl-stat {
        background: var(--white); border-radius: var(--r-lg); padding: 1.4rem 1.6rem;
        box-shadow: var(--shadow-md); display: flex; align-items: center; gap: 1rem;
        opacity: 0; transform: translateY(20px); transition: all .3s;
    }
    .bl-stat.visible { animation: pop-in .45s forwards; }
    @keyframes pop-in { to { opacity: 1; transform: translateY(0); } }
    
    .bl-stat-icon { width: 48px; height: 48px; border-radius: var(--r-sm); display: flex; align-items: center; justify-content: center; font-size: 1.35rem; }
    .bl-stat-icon.amber  { background: var(--amber-pale); color: var(--amber); }
    .bl-stat-icon.green  { background: #E9F7EF; color: #2E7D52; }
    .bl-stat-icon.blue   { background: #EBF4FC; color: #1C6FAB; }
    .bl-stat-val { font-size: 1.8rem; font-weight: 700; line-height: 1; }
    .bl-stat-lbl { font-size: .78rem; color: var(--muted); margin-top: 3px; font-weight: 500; }

    .bl-main { max-width: 1200px; margin: 2.5rem auto; padding: 0 2rem 4rem; display: grid; grid-template-columns: 1fr 340px; gap: 2rem; }
    @media (max-width: 960px) { .bl-main { grid-template-columns: 1fr; } }

    .bl-card { background: var(--white); border-radius: var(--r-lg); padding: 1.5rem; box-shadow: var(--shadow-sm); }
    .bl-card-title { font-family: var(--ff-display); font-size: 1.05rem; font-weight: 700; margin-bottom: 1.1rem; color: var(--text); }
    
    .bl-toast {
        position: fixed; bottom: 1.5rem; right: 1.5rem; background: var(--navy); color: var(--white);
        padding: .75rem 1.2rem; border-radius: var(--r-md); font-size: .85rem; box-shadow: var(--shadow-md);
        display: flex; align-items: center; gap: .6rem; opacity: 0; transform: translateY(12px); transition: all .3s; z-index: 2000;
    }
    .bl-toast.show { opacity: 1; transform: translateY(0); }

    /* Style untuk Bar Progres Info Membaca yang Baru */
    .bl-prog-bar {
        background: #EBF4FC;
        height: 6px;
        border-radius: 10px;
        overflow: hidden;
        margin: 8px 0 16px;
    }
    .bl-prog-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease-in-out;
    }
    .bl-progress-label {
        display: flex;
        justify-content: space-between;
        font-size: .8rem;
    }
</style>
@endpush

@section('content')

{{-- ===== NAVBAR ===== --}}
<nav class="bl-navbar">
    <a href="{{ url('/') }}" class="bl-logo">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
            <rect x="3" y="6" width="16" height="20" rx="3" fill="#C8702A" opacity=".9"/>
            <rect x="7" y="3" width="16" height="20" rx="3" fill="rgba(255,255,255,.2)" stroke="rgba(255,255,255,.4)" stroke-width="1"/>
            <path d="M11 9h8M11 13h8M11 17h5" stroke="rgba(255,255,255,.8)" stroke-width="1.4" stroke-linecap="round"/>
        </svg>
        Book<span>Loop</span>
    </a>

    {{-- 🛠️ MENUNYA KITA GANTI JADI HOME, CATALOG, DAN HISTORY (Home ini ngarah ke dashboard mewahmu, jadi gak bisa balik ke landing page awal!) --}}
    <ul class="bl-nav-links">
        <li><a href="{{ url('/dashboard') }}" class="active">Home</a></li>
        <li><a href="{{ route('catalog.index') }}">Catalog</a></li>
        <li><a href="{{ route('history.index') }}">History</a></li>
    </ul>

    <div class="bl-nav-right">
        <div class="bl-notif" title="Notifications">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <div class="bl-notif-dot"></div>
        </div>
        
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->NamaLengkap ?? 'Siswa') }}&background=C8702A&color=fff" alt="Avatar" class="bl-avatar" data-bs-toggle="dropdown" aria-expanded="false" id="userMenu">
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
            <li><span class="dropdown-item-text small fw-bold text-muted">👋 {{ auth()->user()->NamaLengkap }}</span></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item rounded-2 py-2" href="{{ route('profile.show') }}">👤 &nbsp;My Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item rounded-2 py-2 text-danger" href="{{ url('/logout') }}">🚪 &nbsp;Logout</a></li>
        </ul>
    </div>
</nav>

{{-- ===== HERO ===== --}}
<section class="bl-hero">
    <div class="bl-hero-inner">
        <p class="bl-greeting">✦ PANEL ANGGOTA</p>
        <h1 class="bl-welcome-title">
            Selamat Datang, <em>{{ auth()->user()->NamaLengkap }}</em>!<br>
            Aktivitas Literasimu Dimulai di Sini.
        </h1>
        <p class="bl-hero-sub">Gunakan menu di atas untuk menjelajahi ribuan buku digital.</p>
    </div>
</section>

{{-- ===== STAT CARDS ===== --}}
<div class="bl-stats-row">
    <div class="bl-stat" data-delay="0">
        <div class="bl-stat-icon amber">📖</div>
        <div>
            <div class="bl-stat-val" data-count="0">0</div>
            <div class="bl-stat-lbl">Buku Dipinjam</div>
        </div>
    </div>
    <div class="bl-stat" data-delay="80">
        <div class="bl-stat-icon green">✅</div>
        <div>
            <div class="bl-stat-val" data-count="0">0</div>
            <div class="bl-stat-lbl">Total Dikembalikan</div>
        </div>
    </div>
    <div class="bl-stat" data-delay="160">
        <div class="bl-stat-icon blue">❤️</div>
        <div>
            <div class="bl-stat-val" data-count="0">0</div>
            <div class="bl-stat-lbl">Koleksi Favorit</div>
        </div>
    </div>
</div>

{{-- ===== MAIN CONTENT ===== --}}
<div class="container-fluid px-4" style="max-width: 1200px; margin: 3rem auto 5rem;">
    <div class="w-100">
        
        {{-- HEADLINE JUDUL --}}
        <div class="bl-section-head d-flex align-items-end justify-content-between mb-4">
            <div>
                <p class="section-eyebrow m-0 text-uppercase fw-semibold" style="font-size: .78rem; color: var(--amber); letter-spacing: 1.5px;">
                    ✦ REKOMENDASI UNTUKMU
                </p>
                <h2 class="bl-section-title mt-1 m-0" style="font-family: var(--ff-display); font-size: 2.2rem; font-weight: 700; line-height: 1.2;">
                    Buku yang Paling Banyak <br><span style="color: var(--amber); font-style: italic;">Diminati Anggota</span>
                </h2>
            </div>
            <a href="{{ url('/katalog') }}" class="bl-view-all text-decoration-none fw-bold pb-1" style="font-size: .88rem; color: var(--muted); border-bottom: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.color='var(--amber)'" onmouseout="this.style.color='var(--muted)'">
                Lihat Semua Koleksi →
            </a>
        </div>

        {{-- 📚 GRID KARTU BUKU FULL WIDTH KE SAMPING SECARA DINAMIS --}}
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 mt-2">
            @forelse($favBooks as $b)
            <div class="col">
                <div class="bl-book-card w-100 h-100 border-0 bg-transparent" style="cursor: pointer;">
                    
                    {{-- Bungkus Sampul Buku Efek Bayangan Lembut --}}
                    <div class="book-cover-wrap shadow-sm position-relative mb-3" style="aspect-ratio: 2/3; border-radius: 12px; overflow: hidden; background: var(--navy-soft); transition: all .3s ease;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(30,34,53,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        
                        {{-- Desain Sampul Minimalis Elegan --}}
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white fw-bold" style="font-size: .9rem; text-align: center; padding: 16px; background: linear-gradient(135deg, var(--navy-soft) 0%, #161a29 100%);">
                            <span style="font-size: 1.8rem; margin-bottom: 8px; opacity: 0.8;">📖</span>
                            <span class="px-2" style="line-height: 1.3; font-weight: 600; letter-spacing: -0.2px;">{{ $b->Judul }}</span>
                        </div>
                        
                    </div>

                    {{-- Metadata Info Buku di Bawah Sampul --}}
                    <div class="px-1">
                        <span class="d-block text-uppercase fw-bold" style="font-size: .65rem; color: var(--amber); letter-spacing: 0.8px; margin-bottom: 2px;">TERPOPULER</span>
                        <h3 class="m-0 fw-bold text-dark text-truncate" style="font-family: var(--ff-body); font-size: 1rem; letter-spacing: -0.3px;" title="{{ $b->Judul }}">{{ $b->Judul }}</h3>
                        <p class="m-0 text-muted text-truncate mt-1" style="font-size: .8rem;">👤 {{ $b->Penulis ?? 'Penulis Anonim' }}</p>
                        
                        {{-- Rating Bintang Emas Berjejer --}}
                        <div class="mt-1" style="color: #f4c542; font-size: .75rem; letter-spacing: 1px;">
                            <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i>
                        </div>
                    </div>

                </div>
            </div>
            @empty
            {{-- Jika database kosong --}}
            <div class="col-12 w-100 py-5 text-center bg-white rounded-4 shadow-sm">
                <p class="text-muted m-0 small">Belum ada buku terpopuler yang ditambahkan oleh petugas perpustakaan.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function animateCounter(el) {
    const target = parseInt(el.dataset.count);
    if (isNaN(target) || target === 0) return;
    let current = 0;
    const duration = 1000;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = Math.floor(current);
        if (current >= target) clearInterval(timer);
    }, 16);
}

const statObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const el = entry.target;
            const delay = parseInt(el.dataset.delay || 0);
            setTimeout(() => {
                el.classList.add('visible');
                el.querySelectorAll('[data-count]').forEach(animateCounter);
            }, delay);
            statObserver.unobserve(el);
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.bl-stat').forEach(s => statObserver.observe(s));
</script>
@endpush