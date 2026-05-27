{{-- resources/views/user/katalog.blade.php --}}
@extends('layouts.app')

@section('title', 'Book Catalogue – BookLoop')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    /* ===== TOKENS ===== */
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
        --shadow-md: 0 8px 32px rgba(30,34,53,.13);
        --r-sm:      8px;
        --r-md:      14px;
        --r-lg:      20px;
        --ff-display:'Playfair Display', Georgia, serif;
        --ff-body:   'DM Sans', system-ui, sans-serif;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: var(--ff-body);
        background: var(--cream);
        color: var(--text);
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* ===== NAVBAR ===== */
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
        display: flex; align-items: center; gap: .5rem;
        letter-spacing: -.3px;
    }
    .bl-logo span { color: var(--amber-lt); }
    .bl-nav-links { display: flex; gap: 2rem; list-style: none; }
    .bl-nav-links a {
        color: rgba(255,255,255,.65);
        text-decoration: none;
        font-size: .9rem; font-weight: 500; letter-spacing: .3px;
        padding-bottom: 4px;
        border-bottom: 2px solid transparent;
        transition: color .25s, border-color .25s;
    }
    .bl-nav-links a:hover, .bl-nav-links a.active { color: var(--white); border-color: var(--amber-lt); }
    .bl-nav-right { display: flex; align-items: center; gap: 1rem; }
    .bl-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        border: 2px solid var(--amber-lt);
        object-fit: cover; cursor: pointer;
        transition: transform .2s;
    }
    .bl-avatar:hover { transform: scale(1.08); }
    .bl-notif {
        position: relative; color: rgba(255,255,255,.75);
        cursor: pointer; padding: 6px; border-radius: var(--r-sm);
        transition: background .2s;
    }
    .bl-notif:hover { background: rgba(255,255,255,.1); }
    .bl-notif-dot {
        position: absolute; top: 5px; right: 5px;
        width: 8px; height: 8px;
        background: var(--amber-lt); border-radius: 50%;
        border: 2px solid var(--navy);
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0%,100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: .7; }
    }

    /* ===== PAGE HEADER ===== */
    .bl-page-header {
        padding: 2.8rem 2rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
        opacity: 0;
        animation: slide-up .5s .05s forwards;
    }
    .bl-page-title {
        font-family: var(--ff-display);
        font-size: clamp(1.9rem, 4vw, 2.6rem);
        font-weight: 700;
        color: var(--text);
        line-height: 1.15;
        margin-bottom: .35rem;
    }
    .bl-page-sub { color: var(--amber); font-size: .95rem; font-weight: 500; }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===== SEARCH & FILTER BAR ===== */
    .bl-filter-bar {
        max-width: 1200px;
        margin: 0 auto 2rem;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        opacity: 0;
        animation: slide-up .5s .15s forwards;
    }
    .bl-search-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
    }
    .bl-search-input {
        width: 100%;
        padding: .85rem 1.2rem .85rem 3rem;
        border: none;
        border-radius: 50px;
        background: rgba(30,34,53,.07);
        font-family: var(--ff-body);
        font-size: .95rem;
        color: var(--text);
        outline: none;
        transition: background .2s, box-shadow .2s;
    }
    .bl-search-input::placeholder { color: var(--muted); }
    .bl-search-input:focus {
        background: var(--white);
        box-shadow: 0 0 0 3px rgba(200,112,42,.15), var(--shadow-sm);
    }
    .bl-search-icon {
        position: absolute; left: 1.1rem; top: 50%;
        transform: translateY(-50%);
        font-size: 1.1rem; pointer-events: none;
    }
    .bl-search-clear {
        position: absolute; right: 1rem; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        font-size: 1rem; color: var(--muted);
        display: none; padding: 2px;
        transition: color .2s;
    }
    .bl-search-clear:hover { color: var(--text); }

    .bl-sort-select {
        padding: .75rem 2.2rem .75rem 1rem;
        border: 1.5px solid var(--border);
        border-radius: 50px;
        background: var(--white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237B7F96' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 12px center;
        -webkit-appearance: none;
        font-family: var(--ff-body);
        font-size: .85rem;
        font-weight: 500;
        color: var(--text);
        cursor: pointer;
        outline: none;
        transition: border-color .2s;
        white-space: nowrap;
    }
    .bl-sort-select:focus { border-color: var(--amber); }

    .bl-result-count {
        font-size: .82rem;
        color: var(--muted);
        white-space: nowrap;
        font-weight: 500;
    }
    .bl-result-count strong { color: var(--amber); }

    /* ===== GENRE TABS ===== */
    .bl-genre-tabs {
        max-width: 1200px;
        margin: 0 auto 1.75rem;
        padding: 0 2rem;
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        opacity: 0;
        animation: slide-up .5s .22s forwards;
    }
    .bl-tab {
        padding: .4rem 1.1rem;
        border-radius: 50px;
        font-size: .82rem;
        font-weight: 500;
        cursor: pointer;
        border: 1.5px solid var(--border);
        background: var(--white);
        color: var(--muted);
        transition: all .22s;
        user-select: none;
    }
    .bl-tab:hover { border-color: var(--amber-lt); color: var(--amber); }
    .bl-tab.active {
        background: var(--amber);
        color: var(--white);
        border-color: var(--amber);
        box-shadow: 0 4px 14px rgba(200,112,42,.3);
    }

    /* ===== BOOK GRID ===== */
    .bl-catalog-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem 5rem;
    }
    .bl-book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1.5rem;
    }

    /* ===== BOOK CARD ===== */
    .bl-card {
        background: var(--white);
        border-radius: var(--r-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        position: relative;
        transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .3s;
        opacity: 0;
        transform: translateY(24px);
    }
    .bl-card.visible {
        animation: card-in .45s cubic-bezier(.34,1.4,.64,1) forwards;
    }
    @keyframes card-in {
        to { opacity: 1; transform: translateY(0); }
    }
    .bl-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: var(--shadow-md);
        z-index: 2;
    }

    .bl-cover-wrap {
        position: relative;
        overflow: hidden;
        aspect-ratio: 2/3;
        background: #e8e3db;
    }
    .bl-cover {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .4s;
    }
    .bl-card:hover .bl-cover { transform: scale(1.06); }
    .bl-cover-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 3.5rem;
        background: linear-gradient(135deg, #f0ebe3 0%, #e0d9cf 100%);
    }

    .bl-cover-overlay {
        position: absolute; inset: 0;
        background: rgba(30,34,53,.55);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: .6rem;
        opacity: 0;
        transition: opacity .28s;
    }
    .bl-card:hover .bl-cover-overlay { opacity: 1; }
    .bl-ov-btn {
        padding: .5rem 1.4rem;
        border-radius: 50px;
        font-family: var(--ff-body);
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: transform .18s, background .2s;
        width: 80%;
        text-align: center;
    }
    .bl-ov-btn:hover { transform: scale(1.06); }
    .bl-ov-btn.primary { background: var(--amber); color: var(--white); }
    .bl-ov-btn.primary:hover { background: #a85a1e; }
    .bl-ov-btn.secondary { background: rgba(255,255,255,.18); color: var(--white); border: 1px solid rgba(255,255,255,.4); }
    .bl-ov-btn.secondary:hover { background: rgba(255,255,255,.28); }

    .bl-heart {
        position: absolute; top: .7rem; right: .7rem;
        width: 32px; height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,.9);
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem;
        opacity: 0;
        transform: scale(0.7);
        transition: opacity .25s, transform .25s;
        z-index: 3;
        box-shadow: var(--shadow-sm);
    }
    .bl-card:hover .bl-heart { opacity: 1; transform: scale(1); }
    .bl-heart.loved { opacity: 1 !important; transform: scale(1) !important; }
    .bl-heart.loved span { animation: heartbeat .35s ease; }
    @keyframes heartbeat {
        0%   { transform: scale(1); }
        40%  { transform: scale(1.5); }
        70%  { transform: scale(.9); }
        100% { transform: scale(1); }
    }

    .bl-avail {
        position: absolute; top: .7rem; left: .7rem;
        padding: .25rem .65rem;
        border-radius: 20px;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .4px;
        text-transform: uppercase;
    }
    .bl-avail.yes { background: rgba(46,125,82,.85); color: #fff; }
    .bl-avail.no  { background: rgba(163,48,48,.85); color: #fff; }

    .bl-card-body { padding: .9rem 1rem 1rem; }
    .bl-genre-tag {
        font-size: .68rem;
        font-weight: 700;
        color: var(--amber);
        letter-spacing: .8px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .bl-book-title {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.3;
        margin-bottom: 3px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .bl-book-author { font-size: .75rem; color: var(--muted); margin-bottom: .45rem; }
    .bl-stars { color: var(--amber); font-size: .78rem; letter-spacing: 1px; }
    .bl-stars span { color: var(--muted); font-size: .73rem; margin-left: 3px; }

    .bl-empty {
        grid-column: 1/-1;
        text-align: center;
        padding: 5rem 2rem;
        opacity: 0;
        animation: slide-up .4s forwards;
    }
    .bl-empty-icon { font-size: 3.5rem; margin-bottom: 1rem; }
    .bl-empty-title {
        font-family: var(--ff-display);
        font-size: 1.4rem; font-weight: 700;
        color: var(--text); margin-bottom: .5rem;
    }
    .bl-empty-sub { color: var(--muted); font-size: .9rem; }

    .bl-load-more-wrap { text-align: center; padding: 2.5rem 0 0; }
    .bl-load-btn {
        padding: .75rem 2.5rem;
        border-radius: 50px;
        background: var(--navy);
        color: var(--white);
        border: none;
        font-family: var(--ff-body);
        font-size: .9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 4px 18px rgba(30,34,53,.2);
    }
    .bl-load-btn:hover { background: var(--amber); box-shadow: 0 6px 22px rgba(200,112,42,.35); }
    .bl-load-btn:active { transform: scale(.97); }
    .bl-load-btn.loading { pointer-events: none; opacity: .7; }

    .bl-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(20,24,42,.6);
        backdrop-filter: blur(4px);
        z-index: 2000;
        display: flex; align-items: center; justify-content: center;
        padding: 1.5rem;
        opacity: 0; pointer-events: none;
        transition: opacity .3s;
    }
    .bl-modal-overlay.open { opacity: 1; pointer-events: all; }
    .bl-modal {
        background: var(--white);
        border-radius: var(--r-lg);
        max-width: 540px;
        width: 100%;
        box-shadow: 0 24px 80px rgba(20,24,42,.35);
        overflow: hidden;
        transform: translateY(30px) scale(.97);
        transition: transform .35s cubic-bezier(.34,1.3,.64,1);
    }
    .bl-modal-overlay.open .bl-modal { transform: translateY(0) scale(1); }
    .bl-modal-top {
        display: flex; gap: 1.5rem; padding: 1.75rem;
        border-bottom: 1px solid var(--border);
    }
    .bl-modal-cover {
        width: 110px; flex-shrink: 0;
        border-radius: var(--r-sm);
        overflow: hidden; aspect-ratio: 2/3;
        box-shadow: var(--shadow-md);
        background: #e8e3db;
    }
    .bl-modal-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .bl-modal-cover-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem;
        background: linear-gradient(135deg, #f0ebe3, #e0d9cf);
    }
    .bl-modal-info { flex: 1; }
    .bl-modal-genre { font-size: .72rem; font-weight: 700; color: var(--amber); letter-spacing: .8px; text-transform: uppercase; margin-bottom: 5px; }
    .bl-modal-title { font-family: var(--ff-display); font-size: 1.3rem; font-weight: 700; color: var(--text); line-height: 1.25; margin-bottom: 4px; }
    .bl-modal-author { font-size: .85rem; color: var(--muted); margin-bottom: .75rem; }
    .bl-modal-stars { color: var(--amber); font-size: 1rem; margin-bottom: .75rem; }
    .bl-meta-row { display: flex; gap: 1.2rem; flex-wrap: wrap; }
    .bl-meta-item { font-size: .78rem; }
    .bl-meta-item label { color: var(--muted); display: block; margin-bottom: 1px; }
    .bl-meta-item strong { color: var(--text); font-weight: 600; }
    .bl-modal-body { padding: 1.25rem 1.75rem; }
    .bl-modal-desc { font-size: .88rem; color: var(--muted); line-height: 1.7; margin-bottom: 1.25rem; }
    .bl-modal-footer { display: flex; gap: .75rem; padding: 0 1.75rem 1.75rem; }
    .bl-modal-btn {
        flex: 1; padding: .75rem;
        border-radius: var(--r-sm);
        font-family: var(--ff-body); font-size: .9rem; font-weight: 600;
        border: none; cursor: pointer;
        transition: background .2s, transform .15s;
    }
    .bl-modal-btn:active { transform: scale(.97); }
    .bl-modal-btn.primary { background: var(--amber); color: var(--white); }
    .bl-modal-btn.primary:hover { background: #a85a1e; }
    .bl-modal-btn.outline { background: transparent; color: var(--text); border: 1.5px solid var(--border); }
    .bl-modal-btn.outline:hover { border-color: var(--amber); color: var(--amber); }
    .bl-modal-close {
        position: absolute; top: 1rem; right: 1rem;
        width: 32px; height: 32px;
        border-radius: 50%; background: rgba(30,34,53,.07);
        border: none; cursor: pointer; font-size: 1rem; color: var(--muted);
        display: flex; align-items: center; justify-content: center;
        transition: background .2s, color .2s;
    }
    .bl-modal-close:hover { background: rgba(200,112,42,.12); color: var(--amber); }

    /* ===== TOAST ===== */
    .bl-toast {
        position: fixed; bottom: 1.75rem; right: 1.75rem;
        background: var(--navy); color: var(--white);
        padding: .8rem 1.3rem;
        border-radius: var(--r-md);
        font-size: .85rem; font-weight: 500;
        box-shadow: var(--shadow-md);
        display: flex; align-items: center; gap: .6rem;
        opacity: 0; transform: translateY(14px);
        transition: opacity .3s, transform .3s;
        z-index: 3000; pointer-events: none;
    }
    .bl-toast.show { opacity: 1; transform: translateY(0); }
    .bl-toast-icon { color: var(--amber-lt); font-size: 1rem; }

    .bl-skeleton {
        background: linear-gradient(90deg, #ede9e3 25%, #e0dbd4 50%, #ede9e3 75%);
        background-size: 200% 100%;
        animation: shimmer 1.4s infinite;
        border-radius: var(--r-sm);
    }
    @keyframes shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* ===== MOBILE ===== */
    .bl-fab {
        display: none;
        position: fixed; bottom: 1.5rem; right: 1.5rem;
        width: 52px; height: 52px; border-radius: 50%;
        background: var(--amber); color: var(--white);
        border: none; cursor: pointer;
        align-items: center; justify-content: center;
        font-size: 1.3rem;
        box-shadow: 0 6px 24px rgba(200,112,42,.5);
        z-index: 999; transition: transform .2s;
    }
    .bl-fab:hover { transform: scale(1.1); }
    @media (max-width: 768px) {
        .bl-fab { display: flex; }
        .bl-nav-links { display: none; }
        .bl-page-header { padding: 1.75rem 1rem 1.25rem; }
        .bl-filter-bar { padding: 0 1rem; }
        .bl-genre-tabs { padding: 0 1rem; }
        .bl-catalog-wrap { padding: 0 1rem 5rem; }
        .bl-book-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1rem; }
        .bl-modal-top { flex-direction: column; }
        .bl-modal-cover { width: 100%; aspect-ratio: 3/2; }
    }
</style>
@endpush

@section('content')

{{-- 🛠️ BARU BUNG: LOGIKA SATPAM NAVBAR DINAMIS TERINTEGRASI --}}
<nav class="bl-navbar">
    <a href="{{ route('home') }}" class="bl-logo">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
            <rect x="3" y="6" width="16" height="20" rx="3" fill="#C8702A" opacity=".9"/>
            <rect x="7" y="3" width="16" height="20" rx="3" fill="rgba(255,255,255,.2)" stroke="rgba(255,255,255,.4)" stroke-width="1"/>
            <path d="M11 9h8M11 13h8M11 17h5" stroke="rgba(255,255,255,.8)" stroke-width="1.4" stroke-linecap="round"/>
        </svg>
        Book<span>Loop</span>
    </a>
    
    <ul class="bl-nav-links">
        {{-- Jika sudah login, tombol Home ngarah ke dashboard biar ga mental keluar --}}
        <li><a href="{{ auth()->check() ? url('/dashboard') : route('home') }}">Home</a></li>
        <li><a href="{{ route('catalog.index') }}" class="active">Catalog</a></li>
        <li><a href="{{ route('history.index') }}">History</a></li>
    </ul>

    <div class="bl-nav-right">
        @auth
            {{-- Kalau user SUDAH login, nampilin Avatar Akun Asli --}}
            <div class="bl-notif" title="Notifications">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <div class="bl-notif-dot"></div>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->NamaLengkap) }}&background=C8702A&color=fff"
                 alt="Avatar" class="bl-avatar"
                 data-bs-toggle="dropdown" aria-expanded="false" id="userMenu">
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu"
                style="border-radius:var(--r-md);border:1px solid var(--border);font-family:var(--ff-body);min-width:180px;padding:.5rem;">
                <li><span class="dropdown-item-text small fw-bold text-muted">👋 {{ auth()->user()->NamaLengkap }}</span></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item rounded-2 py-2" href="{{ route('profile.show') }}">👤 &nbsp;My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item rounded-2 py-2 text-danger" href="{{ url('/logout') }}">🚪 &nbsp;Logout</a></li>
            </ul>
        @else
            {{-- Kalau BELUM login, nampilin Tombol Sign In Bersih --}}
            <a href="{{ route('login') }}" class="btn fw-bold px-4 py-2" style="background: var(--amber); color: #fff; border-radius: 50px; font-size: 0.85rem; text-decoration: none;">Sign In</a>
        @endauth
    </div>
</nav>

{{-- PAGE HEADER --}}
<div class="bl-page-header">
    <h1 class="bl-page-title">Book catalogue</h1>
    <p class="bl-page-sub">Explore our library book collection</p>
</div>

{{-- FILTER BAR --}}
<div class="bl-filter-bar">
    <div class="bl-search-wrap">
        <span class="bl-search-icon">🔍</span>
        <input type="text" class="bl-search-input" id="searchInput"
               placeholder="Cari judul, penulis..." autocomplete="off">
        <button class="bl-search-clear" id="searchClear" title="Hapus">✕</button>
    </div>
    <select class="bl-sort-select" id="sortSelect">
        <option value="popular">Terpopuler</option>
        <option value="newest">Terbaru</option>
        <option value="title">A – Z</option>
    </select>
    <span class="bl-result-count" id="resultCount">
        Menampilkan <strong id="countNum">0</strong> buku
    </span>
</div>

{{-- GENRE TABS --}}
<div class="bl-genre-tabs" id="genreTabs">
    <span class="bl-tab active" data-genre="all">Semua</span>
    @foreach(['Fiksi','Non-Fiksi','Sains','Sejarah','Motivasi','Filsafat','Novel','Biografi'] as $g)
        <span class="bl-tab" data-genre="{{ strtolower(str_replace(' ','-',$g)) }}">{{ $g }}</span>
    @endforeach
</div>

{{-- BOOK GRID --}}
<div class="bl-catalog-wrap">
    <div class="bl-book-grid" id="bookGrid">

        {{-- 📚 BARU BUNG: LOOPING DATA ASLI DATABASE SINKRON AMAN --}}
        @forelse($books ?? [] as $i => $b)
            @php
                // Logika pembuat bintang dummy agar visualnya tetap bling-bling memukau
                $rating_dummy = 4.5 + (($b->BukuID ?? $i) % 5) * 0.1; 
                $stars = str_repeat('★', floor($rating_dummy)) . str_repeat('☆', 5 - floor($rating_dummy));
            @endphp
            <div class="bl-card"
                 data-id="{{ $b->BukuID }}"
                 data-genre="all"
                 data-title="{{ strtolower($b->Judul) }}"
                 data-author="{{ strtolower($b->Penulis) }}"
                 data-rating="{{ $rating_dummy }}"
                 data-year="2024"
                 data-delay="{{ ($i % 10) * 50 }}"
                 onclick="openModal(this)">

                <div class="bl-cover-wrap">
                    {{-- Render Cover Buku --}}
                    <div class="bl-cover-placeholder">📚</div>

                    {{-- Status Ketersediaan Buku --}}
                    <span class="bl-avail yes">Tersedia</span>

                    <div class="bl-cover-overlay">
    {{-- Form kirim data pinjam langsung ke database --}}
    <form action="{{ url('/user/peminjaman') }}" method="POST" class="w-100 px-2">
        @csrf
        <input type="hidden" name="BukuID" value="{{ $b->BukuID }}">
        <button type="submit" class="bl-ov-btn primary w-100">
            📖 Pinjam Sekarang
        </button>
    </form>
    
    <button class="bl-ov-btn secondary" onclick="event.stopPropagation(); openModal(this.closest('.bl-card'))">
        Detail Buku
    </button>
</div>

                    <button class="bl-heart" id="heart-{{ $b->BukuID }}"
                            onclick="event.stopPropagation(); toggleWishlist({{ $b->BukuID }}, '{{ addslashes($b->Judul) }}', this)"
                            title="Tambah ke wishlist">
                        <span id="heart-icon-{{ $b->BukuID }}">🤍</span>
                    </button>
                </div>

                <div class="bl-card-body">
                    <div class="bl-genre-tag">Koleksi</div>
                    <div class="bl-book-title">{{ $b->Judul }}</div>
                    <div class="bl-book-author">{{ $b->Penulis }}</div>
                    <div class="bl-stars">{{ $stars }}<span>(24)</span></div>
                </div>

                {{-- JSON Data Transport untuk Modal Slide Up Detail --}}
                <script type="application/json" class="bl-data">
                {
                    "title":  "{{ addslashes($b->Judul) }}",
                    "author": "{{ addslashes($b->Penulis) }}",
                    "genre":  "Koleksi Perpustakaan",
                    "rating": {{ $rating_dummy }},
                    "votes":  24,
                    "year":   2024,
                    "pages":  320,
                    "available": true,
                    "icon":   "📚",
                    "desc":   "Buku berkualitas tinggi berudul {{ addslashes($b->Judul) }} karangan {{ addslashes($b->Penulis) }} yang terdaftar resmi di basis data perpustakaan digital BookLoop."
                }
                </script>
            </div>
        @empty
            <div class="bl-empty">
                <div class="bl-empty-icon">📭</div>
                <div class="bl-empty-title">Tidak ada buku ditemukan</div>
                <p class="bl-empty-sub">Belum ada buku yang diinput oleh admin/petugas di database.</p>
            </div>
        @endforelse
    </div>

    <div class="bl-load-more-wrap" id="loadMoreWrap">
        <button class="bl-load-btn" id="loadMoreBtn" onclick="loadMore()">
            Muat Lebih Banyak ↓
        </button>
    </div>
</div>

{{-- MODAL --}}
<div class="bl-modal-overlay" id="bookModal" onclick="closeModal(event)">
    <div class="bl-modal" style="position:relative">
        <button class="bl-modal-close" onclick="closeModal()">✕</button>
        <div class="bl-modal-top">
            <div class="bl-modal-cover" id="modalCover">
                <div class="bl-modal-cover-placeholder" id="modalIcon">📚</div>
            </div>
            <div class="bl-modal-info">
                <div class="bl-modal-genre" id="modalGenre">Koleksi</div>
                <div class="bl-modal-title" id="modalTitle">–</div>
                <div class="bl-modal-author" id="modalAuthor">–</div>
                <div class="bl-modal-stars" id="modalStars">★★★★★</div>
                <div class="bl-meta-row">
                    <div class="bl-meta-item"><label>Tahun</label><strong id="modalYear">–</strong></div>
                    <div class="bl-meta-item"><label>Halaman</label><strong id="modalPages">–</strong></div>
                    <div class="bl-meta-item"><label>Status</label><strong id="modalStatus">–</strong></div>
                </div>
            </div>
        </div>
        <div class="bl-modal-body">
            <p class="bl-modal-desc" id="modalDesc">–</p>
        </div>
        <div class="bl-modal-footer">
            <button class="bl-modal-btn primary" id="modalBorrowBtn">📖 Pinjam Buku Ini</button>
            <button class="bl-modal-btn outline" id="modalWishBtn">🤍 Wishlist</button>
        </div>
    </div>
</div>

{{-- FAB MOBILE --}}
<button class="bl-fab" onclick="document.getElementById('searchInput').focus()">🔍</button>

{{-- TOAST NOTIFICATION --}}
<div class="bl-toast" id="blToast">
    <span class="bl-toast-icon" id="toastIcon">✓</span>
    <span id="blToastMsg">Berhasil!</span>
</div>

@endsection

@push('scripts')
<script>
/* ===== DATA ===== */
const wishlist = new Set(JSON.parse(localStorage.getItem('bl_wishlist') || '[]'));
let currentModalId = null;

/* ===== CARD OBSERVER (reveal on scroll) ===== */
const cardObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const el = entry.target;
            const delay = parseInt(el.dataset.delay || 0);
            setTimeout(() => el.classList.add('visible'), delay);
            cardObserver.unobserve(el);
        }
    });
}, { threshold: 0.1 });

function observeCards() {
    document.querySelectorAll('.bl-card:not(.visible)').forEach(c => cardObserver.observe(c));
}
observeCards();

/* ===== COUNT ===== */
function updateCount() {
    const visible = document.querySelectorAll('.bl-card:not([style*="display: none"])').length;
    document.getElementById('countNum').textContent = visible;
}

/* ===== INIT WISHLIST STATE ===== */
function initWishlistIcons() {
    wishlist.forEach(id => {
        const icon = document.getElementById('heart-icon-' + id);
        const btn  = document.getElementById('heart-' + id);
        if (icon) { icon.textContent = '❤️'; btn.classList.add('loved'); }
    });
}
initWishlistIcons();
updateCount();

/* ===== SEARCH ===== */
const searchInput = document.getElementById('searchInput');
const searchClear = document.getElementById('searchClear');

searchInput.addEventListener('input', function() {
    const q = this.value.trim().toLowerCase();
    searchClear.style.display = q ? 'block' : 'none';
    filterBooks();
});
searchClear.addEventListener('click', () => {
    searchInput.value = '';
    searchClear.style.display = 'none';
    filterBooks();
    searchInput.focus();
});

/* ===== GENRE TABS ===== */
document.getElementById('genreTabs').addEventListener('click', e => {
    const tab = e.target.closest('.bl-tab');
    if (!tab) return;
    document.querySelectorAll('.bl-tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    filterBooks();
});

/* ===== SORT ===== */
document.getElementById('sortSelect').addEventListener('change', () => sortBooks());

/* ===== FILTER ===== */
function filterBooks() {
    const q     = searchInput.value.trim().toLowerCase();
    const genre = document.querySelector('.bl-tab.active')?.dataset.genre || 'all';

    const cards = document.querySelectorAll('.bl-card');
    let shown = 0;
    cards.forEach(card => {
        const matchGenre = genre === 'all' || card.dataset.genre === genre;
        const matchQ     = !q || card.dataset.title.includes(q) || card.dataset.author.includes(q);
        const show = matchGenre && matchQ;
        card.style.display = show ? '' : 'none';

        if (show) {
            shown++;
            if (!card.classList.contains('visible')) {
                setTimeout(() => card.classList.add('visible'), shown * 40);
                cardObserver.observe(card);
            }
        }
    });

    const existing = document.querySelector('.bl-empty');
    if (existing) existing.remove();
    if (shown === 0) {
        const em = document.createElement('div');
        em.className = 'bl-empty';
        em.innerHTML = `<div class="bl-empty-icon">🔍</div>
            <div class="bl-empty-title">Buku tidak ditemukan</div>
            <p class="bl-empty-sub">Tidak ada buku untuk kata kunci "<strong>${searchInput.value}</strong>".</p>`;
        document.getElementById('bookGrid').appendChild(em);
    }
    updateCount();
}

/* ===== SORT ===== */
function sortBooks() {
    const sort  = document.getElementById('sortSelect').value;
    const grid  = document.getElementById('bookGrid');
    const cards = [...grid.querySelectorAll('.bl-card')];

    cards.sort((a, b) => {
        if (sort === 'title')   return a.dataset.title.localeCompare(b.dataset.title);
        if (sort === 'rating')  return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        if (sort === 'newest')  return parseInt(b.dataset.year) - parseInt(a.dataset.year);
        return 0;
    });

    cards.forEach((c, i) => {
        c.classList.remove('visible');
        grid.appendChild(c);
        setTimeout(() => c.classList.add('visible'), i * 50);
    });
}

/* ===== WISHLIST ===== */
function toggleWishlist(id, title, btn) {
    const icon = document.getElementById('heart-icon-' + id);
    if (wishlist.has(id)) {
        wishlist.delete(id);
        icon.textContent = '🤍';
        btn.classList.remove('loved');
        showToast('🤍', '"' + title + '" dihapus dari wishlist');
    } else {
        wishlist.add(id);
        icon.textContent = '❤️';
        btn.classList.add('loved');
        icon.style.animation = 'none';
        void icon.offsetWidth;
        icon.style.animation = '';
        showToast('❤️', '"' + title + '" ditambahkan ke wishlist!');
    }
    localStorage.setItem('bl_wishlist', JSON.stringify([...wishlist]));
    if (currentModalId === id) updateModalWishBtn();
}

/* ===== BORROW COUPLER ===== */
function quickBorrow(id, title) {
    // 🛠️ Mencegat otomatis proses pinjam jika belum login!
    @if(!auth()->check())
        showToast('⚠️', 'Kamu harus login dahulu Bung untuk meminjam buku!');
        setTimeout(() => { window.location.href = "{{ route('login') }}"; }, 1500);
        return;
    @endif

    showToast('📚', 'Mengajukan pinjaman untuk "' + title + '"...');
}

/* ===== MODAL ===== */
function openModal(card) {
    const raw  = card.querySelector('.bl-data');
    if (!raw) return;
    const data = JSON.parse(raw.textContent);
    const id   = parseInt(card.dataset.id);
    currentModalId = id;

    document.getElementById('modalIcon').textContent = data.icon;
    document.getElementById('modalGenre').textContent = data.genre;
    document.getElementById('modalTitle').textContent = data.title;
    document.getElementById('modalAuthor').textContent = data.author;
    document.getElementById('modalYear').textContent = data.year;
    document.getElementById('modalPages').textContent = data.pages + ' hlm';
    document.getElementById('modalDesc').textContent = data.desc;

    const stars = '★'.repeat(Math.floor(data.rating)) + '☆'.repeat(5 - Math.floor(data.rating));
    document.getElementById('modalStars').textContent = stars + ' ' + data.rating + ' (' + data.votes + ' ulasan)';

    const statusEl = document.getElementById('modalStatus');
    statusEl.textContent = data.available ? '✅ Tersedia' : '🔴 Dipinjam';
    statusEl.style.color = data.available ? '#2E7D52' : '#A33030';

    const borrowBtn = document.getElementById('modalBorrowBtn');
    borrowBtn.disabled = !data.available;
    borrowBtn.style.opacity = data.available ? '1' : '.5';
    borrowBtn.onclick = () => { quickBorrow(id, data.title); closeModal(); };

    updateModalWishBtn();
    document.getElementById('bookModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function updateModalWishBtn() {
    const btn = document.getElementById('modalWishBtn');
    if (!btn || currentModalId === null) return;
    btn.textContent = wishlist.has(currentModalId) ? '❤️ Hapus Wishlist' : '🤍 Tambah Wishlist';
    btn.onclick = () => {
        const card = document.querySelector(`.bl-card[data-id="${currentModalId}"]`);
        const heart = document.getElementById('heart-' + currentModalId);
        const data  = JSON.parse(card.querySelector('.bl-data').textContent);
        toggleWishlist(currentModalId, data.title, heart);
    };
}

function closeModal(e) {
    if (e && e.target !== document.getElementById('bookModal')) return;
    document.getElementById('bookModal').classList.remove('open');
    document.body.style.overflow = '';
    currentModalId = null;
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

/* ===== LOAD MORE ===== */
function loadMore() {
    const btn = document.getElementById('loadMoreBtn');
    btn.textContent = 'Memuat...';
    btn.classList.add('loading');
    setTimeout(() => {
        btn.textContent = 'Tidak ada buku lagi ✓';
        btn.disabled = true;
        btn.style.background = 'var(--muted)';
        btn.style.cursor = 'default';
    }, 1200);
}

/* ===== TOAST ===== */
let toastTimer;
function showToast(icon, msg) {
    document.getElementById('toastIcon').textContent = icon;
    document.getElementById('blToastMsg').textContent = msg;
    const t = document.getElementById('blToast');
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 3000);
}
</script>
@endpush