<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookLoop — Borrow Your Favorite Books</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --navy:    #1e2340;
            --navy2:   #2a2f52;
            --cream:   #f2ede6;
            --sand:    #c9bc9e;
            --burnt:   #c05c1a;
            --burnt2:  #d96a22;
            --slate:   #8a98a8;
            --white:   #ffffff;
            --gold:    #e8935a;
            --font-d:  'Playfair Display', Georgia, serif;
            --font-b:  'DM Sans', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin:0; padding:0; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-b); background: var(--cream); color: var(--navy); overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }

        /* ── PAGE LOADER ── */
        #loader {
            position: fixed; inset: 0; z-index: 9999;
            background: var(--navy);
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem;
            transition: opacity .6s ease, visibility .6s ease;
        }
        #loader.out { opacity: 0; visibility: hidden; pointer-events: none; }
        .ld-logo { font-family: var(--font-d); font-size: 2rem; font-weight: 700; color: var(--white);
            animation: ldPulse 1s ease-in-out infinite alternate; }
        @keyframes ldPulse { from{opacity:.3;transform:scale(.95)} to{opacity:1;transform:scale(1)} }
        .ld-bar { width: 180px; height: 3px; background: rgba(255,255,255,.15); border-radius: 3px; overflow: hidden; }
        .ld-fill { height: 100%; background: linear-gradient(90deg, var(--burnt), var(--gold));
            animation: ldFill 1.3s ease forwards; }
        @keyframes ldFill { from{width:0} to{width:100%} }

        /* ── SCROLL TOP ── */
        #scrollTop {
            position: fixed; bottom: 1.8rem; right: 1.8rem; z-index: 800;
            width: 42px; height: 42px; border-radius: 50%; border: none;
            background: var(--navy); color: var(--white); font-size: 1rem; cursor: pointer;
            box-shadow: 0 4px 18px rgba(0,0,0,.2);
            opacity: 0; transform: translateY(12px);
            transition: opacity .3s, transform .3s, background .2s;
            display: flex; align-items: center; justify-content: center;
        }
        #scrollTop.show { opacity: 1; transform: translateY(0); }
        #scrollTop:hover { background: var(--burnt); }

        /* ── NAVBAR ── */
        .bl-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1030;
            background: var(--navy);
            transition: box-shadow .3s, backdrop-filter .3s;
        }
        .bl-nav.scrolled {
            box-shadow: 0 4px 30px rgba(0,0,0,.28);
            backdrop-filter: blur(12px);
            background: rgba(30,35,64,.95);
        }
        .bl-nav .navbar-brand {
            font-family: var(--font-d); font-size: 1.3rem; font-weight: 700;
            color: var(--white); display: flex; align-items: center; gap: .5rem;
        }
        .bl-nav .nav-link {
            color: rgba(255,255,255,.7) !important; font-size: .9rem; font-weight: 500;
            padding: .5rem .85rem !important; position: relative;
            transition: color .2s;
        }
        .bl-nav .nav-link::after {
            content: ''; position: absolute; bottom: 1px; left: .85rem; right: .85rem;
            height: 2px; background: var(--white); border-radius: 2px;
            transform: scaleX(0); transition: transform .25s;
        }
        .bl-nav .nav-link:hover, .bl-nav .nav-link.active { color: var(--white) !important; }
        .bl-nav .nav-link:hover::after, .bl-nav .nav-link.active::after { transform: scaleX(1); }
        .btn-si {
            background: rgba(255,255,255,.12); border: 1.5px solid rgba(255,255,255,.3);
            color: var(--white) !important; border-radius: 50px;
            padding: .38rem 1.25rem !important; font-weight: 600; font-size: .9rem;
            transition: background .2s, transform .2s;
        }
        .btn-si:hover { background: rgba(255,255,255,.22); transform: translateY(-1px); }
        .navbar-toggler { border: 1.5px solid rgba(255,255,255,.3) !important; padding: .3rem .55rem; }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,.8%29' stroke-linecap='round' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        /* ── HERO ── */
        .hero {
            min-height: 100vh; padding-top: 68px;
            background: var(--cream);
            position: relative; overflow: hidden;
            display: flex; align-items: center;
        }

        /* Sand blobs — faithfully matching the design */
        .blob { position: absolute; background: var(--sand); pointer-events: none; z-index: 0; }
        .blob-tr {
            width: 480px; height: 420px;
            top: -90px; right: -110px;
            border-radius: 40% 60% 65% 35% / 45% 50% 55% 50%;
            animation: bMorph 11s ease-in-out infinite alternate;
        }
        .blob-br {
            width: 280px; height: 280px;
            bottom: -80px; right: -50px;
            border-radius: 60% 40% 30% 70% / 50% 65% 35% 50%;
            opacity: .7;
            animation: bMorph2 13s ease-in-out infinite alternate;
        }
        @keyframes bMorph  { 0%{border-radius:40% 60% 65% 35%/45% 50% 55% 50%} 100%{border-radius:60% 40% 45% 55%/35% 60% 40% 65%} }
        @keyframes bMorph2 { 0%{border-radius:60% 40% 30% 70%/50% 65% 35% 50%} 100%{border-radius:40% 60% 60% 40%/60% 40% 60% 40%} }

        /* particles */
        #ptcl { position: absolute; inset: 0; pointer-events: none; z-index: 0; }

        .hero-inner { position: relative; z-index: 1; }

        .hero-title {
            font-family: var(--font-d);
            font-size: clamp(2.7rem, 5.2vw, 4.4rem);
            font-weight: 900; line-height: 1.06;
            animation: fadeUp .8s ease both;
        }
        .hero-title .accent {
            color: var(--burnt); display: block;
        }
        .hero-title .accent::after {
            content: ''; display: block; width: 0; height: 4px;
            background: linear-gradient(90deg, var(--burnt), var(--gold));
            border-radius: 2px; margin-top: 5px;
            animation: growLine 1s .9s ease forwards;
        }
        @keyframes growLine { to { width: 100%; } }

        .hero-desc { font-size: 1.02rem; color: var(--slate); line-height: 1.72; max-width: 400px; animation: fadeUp .8s .1s ease both; }

        @keyframes fadeUp { from{opacity:0;transform:translateY(26px)} to{opacity:1;transform:translateY(0)} }

        .btn-primary-bl {
            background: var(--navy); color: var(--white); border: none;
            border-radius: 50px; padding: .78rem 1.9rem;
            font-weight: 600; font-size: .95rem;
            box-shadow: 0 4px 18px rgba(30,35,64,.25);
            transition: transform .2s, box-shadow .2s, background .2s;
            display: inline-flex; align-items: center; gap: .5rem;
        }
        .btn-primary-bl:hover { color: var(--white); background: var(--navy2); transform: translateY(-3px); box-shadow: 0 8px 26px rgba(30,35,64,.32); }

        .btn-secondary-bl {
            background: #b0bec5; color: var(--navy); border: none;
            border-radius: 50px; padding: .78rem 1.9rem;
            font-weight: 600; font-size: .95rem;
            transition: transform .2s, box-shadow .2s, background .2s;
            display: inline-flex; align-items: center; gap: .5rem;
        }
        .btn-secondary-bl:hover { background: #9aaab5; transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.1); }

        .books-wrap { display: flex; justify-content: center; align-items: flex-end; }
        .books-wrap svg {
            width: 100%; max-width: 430px;
            filter: drop-shadow(0 20px 50px rgba(0,0,0,.13));
            animation: bookFloat 5.5s ease-in-out infinite;
        }
        @keyframes bookFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-16px)} }

        /* ── HOW TO DO ── */
        .how-section { background: var(--cream); }

        .section-eyebrow {
            display: flex; align-items: center; gap: .6rem;
            font-size: .8rem; font-weight: 600; color: var(--burnt);
            letter-spacing: .04em;
        }
        .section-eyebrow::before {
            content: ''; display: block; width: 28px; height: 2px;
            background: var(--burnt); border-radius: 2px;
        }

        .section-h { font-family: var(--font-d); font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 900; color: var(--navy); line-height: 1.15; }
        .section-sub { font-size: .95rem; color: var(--slate); }

        /* Steps timeline */
        .steps-row { position: relative; }

        /* connecting line between circles */
        .steps-row::before {
            content: '';
            position: absolute;
            top: 38px; left: calc(12.5% + 38px); right: calc(12.5% + 38px);
            height: 2px;
            background: repeating-linear-gradient(90deg, var(--sand) 0, var(--sand) 8px, transparent 8px, transparent 16px);
            z-index: 0;
        }

        .step-col { position: relative; z-index: 1; text-align: center; }

        .step-circle {
            width: 76px; height: 76px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; margin: 0 auto 1rem;
            position: relative; transition: transform .3s, box-shadow .3s;
            cursor: default;
        }
        .step-circle:hover { transform: scale(1.1); box-shadow: 0 8px 28px rgba(0,0,0,.16); }

        .sc-1 { background: var(--navy2); color: var(--white); }
        .sc-2 { background: var(--burnt); color: var(--white); }
        .sc-3 { background: var(--sand); color: var(--navy); }
        .sc-4 { background: var(--navy); color: var(--white); }

        /* pulse ring on active step */
        .step-circle.active-step::after {
            content: '';
            position: absolute; inset: -6px;
            border-radius: 50%;
            border: 2px solid currentColor;
            opacity: .4;
            animation: stepPulse 2s ease-out infinite;
        }
        @keyframes stepPulse { 0%{transform:scale(1);opacity:.4} 100%{transform:scale(1.4);opacity:0} }

        .step-tag { font-size: .75rem; font-weight: 600; color: var(--burnt); margin-bottom: .25rem; letter-spacing: .03em; }
        .step-title { font-family: var(--font-d); font-size: 1.05rem; font-weight: 700; color: var(--navy); margin-bottom: .4rem; }
        .step-desc { font-size: .86rem; color: var(--slate); line-height: 1.6; max-width: 160px; margin: 0 auto; }

        /* ── POPULAR BOOKS ── */
        .books-section { background: var(--navy2); }

        .books-section .section-eyebrow::before { background: var(--gold); }
        .books-section .section-eyebrow { color: var(--gold); }
        .books-section .section-h { color: var(--white); }
        .books-section .section-h span { color: var(--gold); font-style: italic; }

        .view-link {
            font-size: .88rem; color: var(--slate);
            display: inline-flex; align-items: center; gap: .3rem;
            transition: color .2s;
        }
        .view-link:hover { color: var(--white); }

        .book-card {
            background: transparent;
            border: none; cursor: pointer;
        }
        .book-cover-wrap {
            border-radius: 10px; overflow: hidden;
            box-shadow: 0 8px 28px rgba(0,0,0,.35);
            aspect-ratio: 2/3; position: relative;
            transition: transform .3s, box-shadow .3s;
        }
        .book-card:hover .book-cover-wrap {
            transform: translateY(-8px) rotate(-1deg);
            box-shadow: 0 20px 50px rgba(0,0,0,.45);
        }
        .book-cover-wrap img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        /* placeholder if no img */
        .book-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
        }

        .book-badge {
            font-size: .72rem; font-weight: 600; color: var(--slate);
            text-transform: uppercase; letter-spacing: .05em; margin-top: .75rem; display: block;
        }
        .book-name { font-family: var(--font-d); font-size: 1rem; font-weight: 700; color: var(--white); margin: .15rem 0 .1rem; }
        .book-author { font-size: .8rem; color: var(--slate); margin-bottom: .3rem; }
        .stars { color: #f4c542; font-size: .82rem; letter-spacing: .04em; }

        /* ── REVIEWS ── */
        .reviews-section { background: var(--cream); }

        .rating-big {
            background: var(--navy); border-radius: 20px; padding: 2rem 1.75rem;
            color: var(--white); text-align: center;
        }
        .rating-number {
            font-family: var(--font-d); font-size: 4rem; font-weight: 900;
            line-height: 1; color: var(--white);
        }
        .rating-stars-big { font-size: 1.3rem; color: #f4c542; letter-spacing: .1em; margin: .4rem 0 .25rem; }
        .rating-count { font-size: .8rem; color: rgba(255,255,255,.5); }

        .review-card {
            background: var(--white); border-radius: 18px;
            padding: 1.5rem 1.75rem;
            box-shadow: 0 2px 16px rgba(0,0,0,.06);
            border: 1px solid rgba(0,0,0,.04);
            transition: transform .25s, box-shadow .25s;
        }
        .review-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,.1); }

        .review-book-cover {
            width: 44px; height: 60px; border-radius: 5px; object-fit: cover;
            box-shadow: 0 3px 10px rgba(0,0,0,.2);
            flex-shrink: 0;
        }
        .review-book-cover-placeholder {
            width: 44px; height: 60px; border-radius: 5px;
            background: var(--cream); display: flex; align-items: center;
            justify-content: center; font-size: 1.2rem; flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(0,0,0,.1);
        }
        .review-title { font-weight: 700; font-size: .95rem; color: var(--navy); }
        .review-author { font-size: .78rem; color: var(--slate); }
        .rv-stars { color: #f4c542; font-size: .8rem; }
        .review-text { font-size: .88rem; color: #5a6370; line-height: 1.65; margin: .75rem 0; font-style: italic; }

        .reviewer-avatar {
            width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;
        }
        .reviewer-avatar-placeholder {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, var(--sand), var(--gold));
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; font-weight: 700; color: var(--navy); flex-shrink: 0;
        }
        .reviewer-name { font-size: .85rem; font-weight: 600; color: var(--navy); }
        .reviewer-role { font-size: .75rem; color: var(--burnt); font-weight: 600; }
        .helpful-text { font-size: .78rem; color: var(--slate); display: flex; align-items: center; gap: .3rem; }

        .big-quote {
            font-family: var(--font-d); font-size: 9rem; font-weight: 900;
            color: rgba(30,35,64,.06); line-height: .8;
            position: absolute; top: 0; left: -10px;
            pointer-events: none; user-select: none;
        }

        /* ── CTA BANNER ── */
        .cta-section { background: var(--navy); position: relative; overflow: hidden; }
        .cta-section::before {
            content: ''; position: absolute;
            width: 350px; height: 350px; border-radius: 50%;
            background: rgba(192,92,26,.12);
            top: -100px; right: -80px; pointer-events: none;
        }
        .cta-section::after {
            content: ''; position: absolute;
            width: 250px; height: 250px; border-radius: 50%;
            background: rgba(100,120,190,.07);
            bottom: -80px; left: -60px; pointer-events: none;
        }

        .cta-h {
            font-family: var(--font-d);
            font-size: clamp(1.8rem, 3.5vw, 2.8rem);
            font-weight: 900; color: var(--white); line-height: 1.15;
        }
        .cta-sub { font-size: .9rem; color: rgba(255,255,255,.5); margin-top: .5rem; }

        .btn-cta {
            background: var(--burnt); color: var(--white); border: none;
            border-radius: 50px; padding: .85rem 2rem;
            font-weight: 700; font-size: .95rem;
            box-shadow: 0 4px 22px rgba(192,92,26,.38);
            transition: transform .2s, box-shadow .2s, background .2s;
            display: inline-flex; align-items: center; gap: .5rem;
            position: relative; z-index: 1;
        }
        .btn-cta:hover { color: var(--white); background: var(--burnt2); transform: translateY(-3px); box-shadow: 0 8px 30px rgba(192,92,26,.48); }
        .btn-cta-ring {
            position: relative; display: inline-block;
        }
        .btn-cta-ring::before {
            content: ''; position: absolute; inset: -7px;
            border-radius: 50px; border: 2px solid rgba(192,92,26,.4);
            animation: ringPulse 2s ease-out infinite;
        }
        @keyframes ringPulse { 0%{transform:scale(1);opacity:1} 100%{transform:scale(1.18);opacity:0} }

        /* ── FOOTER ── */
        .bl-footer { background: var(--navy); border-top: 1px solid rgba(255,255,255,.07); }
        .footer-brand { font-family: var(--font-d); font-size: 1.2rem; font-weight: 700; color: var(--white); }
        .footer-link { font-size: .85rem; color: rgba(255,255,255,.45); transition: color .2s; }
        .footer-link:hover { color: rgba(255,255,255,.85); }
        .footer-copy { font-size: .8rem; color: rgba(255,255,255,.3); }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            .steps-row::before { display: none; }
            .step-desc { max-width: 100%; }
        }
        @media (max-width: 767px) {
            .hero { padding-top: 76px; }
            .books-wrap { margin-top: 2rem; }
            .cta-section .d-flex { flex-direction: column; gap: 1.5rem; text-align: center; }
            .btn-cta-ring { align-self: center; }
        }
        @media (max-width: 575px) {
            .hero-title { font-size: 2.3rem; }
        }
    </style>
</head>
<body>

{{-- PAGE LOADER --}}
<div id="loader">
    <div class="ld-logo">📖 BookLoop</div>
    <div class="ld-bar"><div class="ld-fill"></div></div>
</div>

{{-- SCROLL TOP --}}
<button id="scrollTop" aria-label="Kembali ke atas">
    <i class="bi bi-arrow-up"></i>
</button>

{{-- ════════════════════════════
     NAVBAR (Sudah Dirapikan Sebelum Login)
════════════════════════════ --}}
<nav class="bl-nav navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <svg width="32" height="32" viewBox="0 0 36 36" fill="none" aria-hidden="true">
                <rect x="6"  y="10" width="24" height="18" rx="3" fill="#4a6fa5" opacity=".3"/>
                <rect x="8"  y="8"  width="20" height="18" rx="3" fill="#e8c07d"/>
                <rect x="10" y="8"  width="16" height="18" rx="2" fill="#f5dfa0"/>
                <line x1="13" y1="13"   x2="23" y2="13"   stroke="#c05c1a" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="13" y1="16.5" x2="23" y2="16.5" stroke="#c05c1a" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="13" y1="20"   x2="19" y2="20"   stroke="#c05c1a" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="26" cy="7"  r="1.5" fill="#f4d03f"/>
                <circle cx="30" cy="10" r="1"   fill="#e74c3c"/>
                <circle cx="28" cy="4"  r="1"   fill="#2ecc71"/>
            </svg>
            BookLoop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
    <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">home</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">catalog</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('history.index') }}">history</a></li>
    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
        <a class="nav-link btn-si" href="{{ route('login') }}">sign in</a>
    </li>
</ul>
        </div>
    </div>
</nav>

{{-- ════════════════════════════
     HERO
════════════════════════════ --}}
<section class="hero">
    <div class="blob blob-tr"></div>
    <div class="blob blob-br"></div>
    <div id="ptcl"></div>

    <div class="container hero-inner">
        <div class="row align-items-center gy-5">
            {{-- Text --}}
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
                <h1 class="hero-title mb-3">
                    Borrow your<br>favorite books,
                    <span class="accent">anytime, anywhere</span>
                </h1>
                <p class="hero-desc mb-4">
                    Access a selection of thousands of books.
                    Borrow, read, and return them — all from your
                    screen, no waiting in line.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn-primary-bl">
                        <i class="bi bi-book-half"></i> Start to Borrow
                    </a>
                    <a href="{{ route('catalog.index') }}" class="btn-secondary-bl">
                        <i class="bi bi-grid-3x3-gap"></i> Collection
                    </a>
                </div>
            </div>
            {{-- Books SVG --}}
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800" data-aos-delay="150">
                <div class="books-wrap">
                    <svg viewBox="0 0 420 360" xmlns="http://www.w3.org/2000/svg" aria-label="Tumpukan buku">
                        <ellipse cx="210" cy="335" rx="148" ry="20" fill="rgba(150,160,175,.25)"/>
                        {{-- Book 1: tall pink left --}}
                        <rect x="62"  y="70"  width="42" height="258" rx="6" fill="#e8aabb"/>
                        <rect x="62"  y="70"  width="9"  height="258" rx="5" fill="#d4899e"/>
                        <rect x="70"  y="115" width="29" height="7"   rx="2" fill="#c96f8a" opacity=".55"/>
                        <rect x="70"  y="175" width="29" height="14"  rx="3" fill="#e8c4cc" opacity=".55"/>
                        {{-- Book 2: orange leaning --}}
                        <g transform="rotate(-4,136,248)">
                        <rect x="107" y="106" width="40" height="218" rx="6" fill="#e8935a"/>
                        <rect x="107" y="106" width="9"  height="218" rx="5" fill="#d4783e"/>
                        <rect x="115" y="152" width="25" height="6"   rx="2" fill="#b85e2a" opacity=".5"/>
                        <rect x="115" y="195" width="25" height="14"  rx="3" fill="#f5c09a" opacity=".4"/>
                        </g>
                        {{-- Book 3: teal --}}
                        <rect x="150" y="90"  width="36" height="238" rx="6" fill="#6bbfbf"/>
                        <rect x="150" y="90"  width="8"  height="238" rx="5" fill="#52a8a8"/>
                        <rect x="157" y="135" width="22" height="6"   rx="2" fill="#3d9090" opacity=".5"/>
                        <rect x="157" y="200" width="22" height="12"  rx="3" fill="#9ddede" opacity=".4"/>
                        {{-- Book 4: purple TALLEST --}}
                        <rect x="188" y="46"  width="46" height="282" rx="6" fill="#a78ecf"/>
                        <rect x="188" y="46"  width="10" height="282" rx="5" fill="#8e73ba"/>
                        <rect x="197" y="95"  width="30" height="7"   rx="2" fill="#7259a8" opacity=".55"/>
                        <rect x="197" y="110" width="23" height="5"   rx="2" fill="#7259a8" opacity=".4"/>
                        <rect x="197" y="180" width="30" height="16"  rx="3" fill="#c4aae8" opacity=".45"/>
                        {{-- Book 5: light pink --}}
                        <rect x="236" y="56"  width="42" height="272" rx="6" fill="#f5b8c4"/>
                        <rect x="236" y="56"  width="9"  height="272" rx="5" fill="#e8a0ae"/>
                        <rect x="244" y="102" width="25" height="16"  rx="3" fill="#d4889a" opacity=".5"/>
                        <rect x="244" y="168" width="25" height="7"   rx="2" fill="#d4889a" opacity=".35"/>
                        {{-- Book 6: blue --}}
                        <rect x="280" y="120" width="36" height="208" rx="6" fill="#7a9ccf"/>
                        <rect x="280" y="120" width="8"  height="208" rx="5" fill="#6082ba"/>
                        <rect x="287" y="160" width="20" height="6"   rx="2" fill="#4a6ba0" opacity=".5"/>
                        <rect x="287" y="200" width="20" height="12"  rx="3" fill="#a8c4e8" opacity=".4"/>
                        {{-- Book 7: maroon leaning right --}}
                        <g transform="rotate(5,326,262)">
                        <rect x="313" y="146" width="34" height="180" rx="6" fill="#b87090"/>
                        <rect x="313" y="146" width="7"  height="180" rx="5" fill="#9a5a78"/>
                        <rect x="320" y="190" width="19" height="5"   rx="2" fill="#7a3a58" opacity=".45"/>
                        </g>
                        {{-- Sparkles --}}
                        <circle cx="85"  cy="52"  r="4.5" fill="#f4d03f" opacity=".85"><animate attributeName="opacity" values=".85;.2;.85" dur="2.4s" repeatCount="indefinite"/></circle>
                        <circle cx="348" cy="78"  r="3"   fill="#e74c3c" opacity=".7"><animate attributeName="opacity" values=".7;.1;.7" dur="3.1s" repeatCount="indefinite"/></circle>
                        <circle cx="56"  cy="200" r="5"   fill="#2ecc71" opacity=".5"><animate attributeName="opacity" values=".5;.1;.5" dur="2.9s" repeatCount="indefinite"/></circle>
                        <circle cx="372" cy="175" r="3.5" fill="#a78ecf" opacity=".6"><animate attributeName="opacity" values=".6;.1;.6" dur="3.6s" repeatCount="indefinite"/></circle>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════
     HOW TO DO — 4 STEPS
════════════════════════════ --}}
<section class="how-section py-5">
    <div class="container py-3">
        <div data-aos="fade-up">
            <p class="section-eyebrow mb-2">How to do</p>
            <h2 class="section-h">Borrow books in 4 easy steps</h2>
            <p class="section-sub mt-2">No need to come to the library — all processes are done online.</p>
        </div>

        <div class="row steps-row g-4 mt-4">
            {{-- Step 1 --}}
            <div class="col-6 col-md-3 step-col" data-aos="fade-up" data-aos-delay="0">
                <div class="step-circle sc-1 active-step">
                    <i class="bi bi-person-fill"></i>
                </div>
                <p class="step-tag">01 — Start</p>
                <h3 class="step-title">Create an Account</h3>
                <p class="step-desc">Daftar gratis dengan email atau nomor anggota perpustakaan. Proses hanya 1 menit.</p>
            </div>
            {{-- Step 2 --}}
            <div class="col-6 col-md-3 step-col" data-aos="fade-up" data-aos-delay="100">
                <div class="step-circle sc-2">
                    <i class="bi bi-heart-fill"></i>
                </div>
                <p class="step-tag">02 — Search</p>
                <h3 class="step-title">Find Your Favorite Book</h3>
                <p class="step-desc">Browse our collection and find the perfect book for your reading mood today.</p>
            </div>
            {{-- Step 3 --}}
            <div class="col-6 col-md-3 step-col" data-aos="fade-up" data-aos-delay="200">
                <div class="step-circle sc-3">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <p class="step-tag">03 — Borrow</p>
                <h3 class="step-title">Confirmation</h3>
                <p class="step-desc">Click "borrow," select a term of 7–14 days. Confirmation will be sent directly to your email.</p>
            </div>
            {{-- Step 4 --}}
            <div class="col-6 col-md-3 step-col" data-aos="fade-up" data-aos-delay="300">
                <div class="step-circle sc-4">
                    <i class="bi bi-book-fill"></i>
                </div>
                <p class="step-tag">04 — Return</p>
                <h3 class="step-title">Return the book</h3>
                <p class="step-desc">Return books digitally through your account dashboard within the specified timeframe.</p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════
     MOST BORROWED BOOKS
════════════════════════════ --}}
<section class="books-section py-5">
    <div class="container py-3">
        <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4" data-aos="fade-up">
            <div>
                <p class="section-eyebrow mb-2">Books that are often borrowed</p>
                <h2 class="section-h">
                    The most frequently<br>
                    <span>borrowed books</span>
                </h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="view-link">
                View all collections <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        {{-- Book cards row — real book covers from design --}}
        <div class="row g-3 g-md-4">
            @php
            $books = [
                ['title'=>'Pulang',          'author'=>'Tere Liye',          'genre'=>'Fiksi', 'color'=>'#c8956c', 'emoji'=>'🏡', 'rating'=>5],
                ['title'=>'Filosofi Teras',  'author'=>'Henry Manampiring',  'genre'=>'Fiksi', 'color'=>'#4a7c59', 'emoji'=>'🧘', 'rating'=>5],
                ['title'=>'Perahu Kertas',   'author'=>'Dee Lestari',        'genre'=>'Fiksi', 'color'=>'#2a7da8', 'emoji'=>'🚢', 'rating'=>5],
                ['title'=>'Laut Bercerita',  'author'=>'Leila S. Chudori',   'genre'=>'Fiksi', 'color'=>'#3a5f8a', 'emoji'=>'🌊', 'rating'=>5],
                ['title'=>'Madilog',         'author'=>'Tan Malaka',         'genre'=>'Fiksi', 'color'=>'#8b2323', 'emoji'=>'📕', 'rating'=>5],
            ];
            @endphp

            @foreach($books as $i => $book)
            <div class="col-6 col-md-4 col-lg"
                 data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="book-card w-100">
                    <div class="book-cover-wrap"
                         style="background:{{ $book['color'] }}">
                        <div class="book-placeholder">{{ $book['emoji'] }}</div>
                        {{--
                            Kalau punya cover asli, ganti dengan:
                            <img src="{{ asset('images/books/'.Str::slug($book['title']).'.jpg') }}" alt="{{ $book['title'] }}">
                        --}}
                    </div>
                    <span class="book-badge">{{ $book['genre'] }}</span>
                    <div class="book-name">{{ $book['title'] }}</div>
                    <div class="book-author">{{ $book['author'] }}</div>
                    <div class="stars">{{ str_repeat('★', $book['rating']) }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════
     READER REVIEWS
════════════════════════════ --}}
<section class="reviews-section py-5">
    <div class="container py-3">
        <div class="row align-items-start g-5">
            {{-- Left: heading + rating --}}
            <div class="col-lg-4" data-aos="fade-right" data-aos-duration="700">
                <p class="section-eyebrow mb-3">Reader Reviews</p>
                <h2 class="section-h" style="font-size:clamp(2rem,4vw,3rem); line-height:1.1">
                    what do<br>they say?
                </h2>
                <p class="section-sub mt-3">
                    Lebih dari 8.000 pembaca aktif telah mempercayai BookLoop untuk perjalanan literasi mereka.
                </p>
                <div class="rating-big mt-4">
                    <div class="rating-number" id="ratingCount">0</div>
                    <div class="rating-stars-big">★★★★★</div>
                    <div class="rating-count">dari 2.400+ ulasan</div>
                    {{-- mini bar chart --}}
                    <div class="mt-3" style="text-align:left">
                        @foreach([['5 ★', 82], ['4 ★', 12], ['3 ★', 4], ['2 ★', 1], ['1 ★', 1]] as $r)
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span style="font-size:.72rem;color:rgba(255,255,255,.5);width:28px;flex-shrink:0">{{ $r[0] }}</span>
                            <div style="flex:1;height:5px;background:rgba(255,255,255,.12);border-radius:3px;overflow:hidden">
                                <div style="width:{{ $r[1] }}%;height:100%;background:#f4c542;border-radius:3px;
                                    transition:width 1.5s ease;transform-origin:left"
                                     class="bar-fill" data-width="{{ $r[1] }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: review cards --}}
            <div class="col-lg-8">
                <div class="position-relative">
                    <span class="big-quote">"</span>
                </div>

                {{-- Review 1 --}}
                <div class="review-card mb-3" data-aos="fade-left" data-aos-delay="0">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="book-cover-wrap" style="width:44px;height:60px;border-radius:5px;background:#c8956c;flex-shrink:0;box-shadow:0 3px 10px rgba(0,0,0,.2)">
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:1.2rem">🏡</div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="review-title">Pulang</div>
                            <div class="review-author">Tere Liye</div>
                        </div>
                        <div class="rv-stars">★★★★★</div>
                    </div>
                    <p class="review-text">
                        "A book that makes you cry from the first page to the last. The plot is powerful and the characters feel real."
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="reviewer-avatar-placeholder">E</div>
                            <div>
                                <div class="reviewer-name">edwardz_</div>
                                <div class="reviewer-role">Member</div>
                            </div>
                        </div>
                        <div class="helpful-text">
                            <i class="bi bi-hand-thumbs-up"></i> Helpful (42)
                        </div>
                    </div>
                </div>

                {{-- Review 2 --}}
                <div class="review-card" data-aos="fade-left" data-aos-delay="120">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="book-cover-wrap" style="width:44px;height:60px;border-radius:5px;background:#4a7c59;flex-shrink:0;box-shadow:0 3px 10px rgba(0,0,0,.2)">
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:1.2rem">🧘</div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="review-title">Filosofi Teras</div>
                            <div class="review-author">Henry Manampiring</div>
                        </div>
                        <div class="rv-stars">★★★★★</div>
                    </div>
                    <p class="review-text">
                        "Tidak menyangka filsafat Stoik bisa serelatable ini. Buku ini benar-benar mengubah cara saya merespons masalah sehari-hari."
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="reviewer-avatar-placeholder">S</div>
                            <div>
                                <div class="reviewer-name">sari.reads</div>
                                <div class="reviewer-role">Verified</div>
                            </div>
                        </div>
                        <div class="helpful-text">
                            <i class="bi bi-hand-thumbs-up"></i> Helpful (38)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════
     CTA BANNER
════════════════════════════ --}}
<section class="cta-section py-5">
    <div class="container py-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-4"
             data-aos="fade-up" data-aos-duration="700">
            <div style="position:relative;z-index:1">
                <h2 class="cta-h">Mulai membaca lebih cerdas hari ini</h2>
                <p class="cta-sub">Daftar gratis — tidak perlu kartu kredit.</p>
            </div>
            <div class="btn-cta-ring">
                <a href="{{ route('register') }}" class="btn-cta">
                    Daftar Gratis <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════
     FOOTER
════════════════════════════ --}}
<footer class="bl-footer py-4">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <span class="footer-brand">BookLoop</span>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="#" class="footer-link">Tentang</a>
                <a href="{{ route('catalog.index') }}" class="footer-link">Koleksi</a>
                <a href="#" class="footer-link">Privasi</a>
                <a href="#" class="footer-link">Kontak</a>
            </div>
            <span class="footer-copy">© {{ date('Y') }} BookLoop</span>
        </div>
    </div>
</footer>

{{-- ══════ SCRIPTS ══════ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* 1 — Page loader */
    const loader = document.getElementById('loader');
    setTimeout(() => loader.classList.add('out'), 1350);

    /* 2 — AOS */
    AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 55 });

    /* 3 — Navbar scroll */
    const nav = document.querySelector('.bl-nav');
    window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 40));

    /* 4 — Scroll top btn */
    const stBtn = document.getElementById('scrollTop');
    window.addEventListener('scroll', () => stBtn.classList.toggle('show', scrollY > 300));
    stBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    /* 5 — Floating particles (hero) */
    const ptcl = document.getElementById('ptcl');
    const pColors = ['#e8935a','#a78ecf','#6bbfbf','#f5b8c4','#7a9ccf','#e8c07d','#b87090'];
    for (let i = 0; i < 16; i++) {
        const d = document.createElement('div');
        const sz = Math.random() * 9 + 5;
        Object.assign(d.style, {
            position: 'absolute',
            width: sz + 'px', height: sz + 'px',
            borderRadius: '50%',
            background: pColors[Math.floor(Math.random() * pColors.length)],
            left: Math.random() * 100 + '%',
            bottom: '-' + sz + 'px',
            opacity: '0',
            animation: `floatUp ${Math.random() * 8 + 10}s ${Math.random() * 12}s linear infinite`,
            pointerEvents: 'none'
        });
        ptcl.appendChild(d);
    }
    // inject keyframe if not already present
    if (!document.getElementById('floatKf')) {
        const s = document.createElement('style');
        s.id = 'floatKf';
        s.textContent = `
            @keyframes floatUp {
                0%   { transform: translateY(0) rotate(0deg);   opacity: 0; }
                10%  { opacity: .55; }
                90%  { opacity: .2; }
                100% { transform: translateY(-520px) rotate(360deg); opacity: 0; }
            }
        `;
        document.head.appendChild(s);
    }

    /* 6 — Rating counter animation */
    let rated = false;
    const ratingEl = document.getElementById('ratingCount');
    const ratingObs = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting && !rated) {
            rated = true;
            let n = 0, target = 4.8, dur = 1600, step = 16;
            const inc = target / (dur / step);
            const t = setInterval(() => {
                n = Math.min(n + inc, target);
                ratingEl.textContent = n.toFixed(1);
                if (n >= target) clearInterval(t);
            }, step);
        }
    }, { threshold: .5 });
    if (ratingEl) ratingObs.observe(ratingEl);

    /* 7 — Rating bar animation on scroll */
    const barObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.width = e.target.dataset.width + '%';
            }
        });
    }, { threshold: .2 });
    document.querySelectorAll('.bar-fill').forEach(b => {
        b.style.width = '0';
        barObs.observe(b);
    });

    /* 8 — Step circles: scroll-activate pulse */
    const stepCircles = document.querySelectorAll('.step-circle');
    const stepObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) e.target.classList.add('active-step');
        });
    }, { threshold: .6 });
    stepCircles.forEach(c => stepObs.observe(c));
});
</script>
</body>
</html>