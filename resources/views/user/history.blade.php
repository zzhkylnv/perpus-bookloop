<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookLoop – Borrowing History</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ─── CSS Variables Murni Dari Template Pilihanmu ─── */
        :root {
            --navy:    #1a1f35;
            --cream:   #f5f0e8;
            --sand:    #e8dfd0;
            --accent:  #c0392b;
            --gold:    #d4a017;
            --green:   #2e7d52;
            --yellow:  #b8860b;
            --pink-bg: #fde8e8;
            --green-bg:#e8f5ee;
            --yellow-bg:#fef9e7;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            color: #222;
            overflow-x: hidden;
        }

        /* ─── Navbar ─── */
        .navbar-bookloop {
            background: var(--navy);
            padding: 14px 32px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,.3);
        }
        .navbar-bookloop .brand {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-links a {
            color: rgba(255,255,255,.75);
            text-decoration: none;
            font-size: .95rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 6px;
            transition: all .2s;
        }
        .nav-links a:hover { color: #fff; background: rgba(255,255,255,.1); }
        .nav-links a.active { color: #fff; border-bottom: 2px solid #fff; border-radius: 0; }
        .avatar-wrap img { width: 42px; height: 42px; border-radius: 50%; border: 2px solid rgba(255,255,255,.4); object-fit: cover; }

        /* ─── Page Header ─── */
        .page-header { padding: 40px 0 10px; animation: fadeDown .5s ease both; }
        .page-title { font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 900; color: var(--navy); margin: 0; }

        /* ─── Search Box ─── */
        .search-wrap { position: relative; max-width: 380px; width: 100%; }
        .search-wrap input { background: var(--sand); border: none; border-radius: 50px; padding: 10px 48px 10px 22px; font-size: .93rem; color: #333; width: 100%; }
        .search-wrap input:focus { outline: none; box-shadow: 0 0 0 3px rgba(26,31,53,.2); }
        .search-wrap .search-btn { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.2rem; color: #555; }

        /* ─── Stat Cards ─── */
        .stat-section { padding: 24px 0; }
        .stat-card {
            background: #fff;
            border: 1.5px solid rgba(0,0,0,.09);
            border-radius: 18px;
            padding: 28px 24px 22px;
            text-align: center;
            transition: transform .25s, box-shadow .25s, background .25s;
            animation: fadeUp .6s ease both;
            cursor: pointer;
        }
        .stat-card:hover, .stat-card.active { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,.1); }
        .stat-card[data-filter="all"].active { border-color: var(--navy); }
        .stat-card[data-filter="returned"].active { background: #fffde7; border-color: #ffc107; }
        .stat-card[data-filter="finished"].active { background: #f0fdf4; border-color: #28a745; }

        .stat-number { font-family: 'Playfair Display', serif; font-size: 3.2rem; font-weight: 900; line-height: 1; color: var(--navy); display: block; }
        .stat-label { font-size: .88rem; color: #666; margin-top: 6px; font-weight: 500; text-transform: uppercase; letter-spacing: .03em; }

        /* ─── Divider ─── */
        .section-divider { height: 2px; background: linear-gradient(90deg, var(--accent) 0%, transparent 100%); border-radius: 2px; margin: 8px 0 28px; opacity: .6; }

        /* ─── Book Cards ─── */
        .books-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; padding-bottom: 60px; }
        .book-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.07); transition: transform .25s, box-shadow .25s; cursor: pointer; }
        .book-card:hover { transform: translateY(-5px); box-shadow: 0 14px 36px rgba(0,0,0,.13); }
        .book-card-inner { display: flex; align-items: flex-end; position: relative; height: 160px; overflow: hidden; }
        .book-cover-placeholder { width: 110px; height: 100%; background: linear-gradient(135deg, #2c1654, #8b1a1a); flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: #fff; font-family: 'Playfair Display', serif; font-size: .75rem; text-align: center; padding: 8px; }
        .book-info-overlay { background: var(--accent); color: #fff; flex: 1; height: 100%; padding: 16px 14px; display: flex; flex-direction: column; justify-content: space-between; }
        .book-genre { font-size: .72rem; font-weight: 600; text-transform: uppercase; opacity: .85; }
        .book-title-card { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; line-height: 1.2; margin: 4px 0 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .book-author-card { font-size: .8rem; opacity: .85; }
        .book-card-bottom { display: flex; justify-content: space-between; align-items: center; }
        .stars { color: var(--gold); font-size: .85rem; }
        .badge-status-card { font-size: .72rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; background: rgba(255,255,255,.2); text-transform: uppercase; }

        .btn-detail { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.3); color: #fff; font-size: .78rem; font-weight: 600; padding: 5px 13px; border-radius: 20px; }
        .btn-detail:hover { background: rgba(255,255,255,.3); color: #fff; }

        /* ─── Modal ─── */
        .modal-bookloop .modal-content { border: none; border-radius: 22px; overflow: hidden; box-shadow: 0 30px 80px rgba(0,0,0,.25); animation: modalPop .35s cubic-bezier(.34,1.56,.64,1) both; }
        .modal-header-custom { padding: 24px 24px 20px; display: flex; align-items: flex-start; gap: 18px; position: relative; }
        .modal-header-custom.status-waiting  { background: #f5f5c8; }
        .modal-header-custom.status-approved { background: #c8f5d8; }
        .modal-header-custom.status-rejected { background: #f5c8c8; }

        .modal-cover-placeholder { width: 90px; height: 115px; background: linear-gradient(135deg, #2c1654, #8b1a1a); border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: #fff; font-family: 'Playfair Display', serif; font-size: .7rem; text-align: center; padding: 8px; box-shadow: 0 6px 18px rgba(0,0,0,.25); }
        .modal-book-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 900; color: var(--navy); margin: 0 0 2px; }
        .modal-book-author { color: #555; font-size: .95rem; margin-bottom: 10px; }
        
        .status-badge { display: inline-flex; align-items: center; gap: 6px; font-size: .8rem; font-weight: 600; padding: 5px 14px; border-radius: 20px; }
        .status-badge.waiting  { background: #fff3cd; color: #856404; }
        .status-badge.approved { background: #d1edda; color: #155724; }
        .status-badge.rejected { background: #f8d7da; color: #842029; }
        .status-badge .dot { width: 8px; height: 8px; border-radius: 50%; }
        .status-badge.waiting .dot  { background: #ffc107; }
        .status-badge.approved .dot { background: #28a745; }
        .status-badge.rejected .dot { background: #dc3545; }

        .btn-back-modal { position: absolute; top: 16px; right: 16px; width: 36px; height: 36px; background: rgba(0,0,0,.08); border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #333; }
        .modal-body-custom { background: #f9f6f0; padding: 0 24px 20px; }
        .detail-table { width: 100%; border-collapse: collapse; }
        .detail-table tr { border-bottom: 1px solid rgba(0,0,0,.07); }
        .detail-table tr:last-child { border-bottom: none; }
        .detail-table td { padding: 13px 0; font-size: .9rem; }
        .detail-table td:first-child { color: #777; width: 45%; }
        .detail-table td:last-child { color: #111; font-weight: 500; text-align: right; }

        .status-pill { display: inline-flex; align-items: center; gap: 6px; font-size: .82rem; font-weight: 600; padding: 5px 14px; border-radius: 20px; }
        .status-pill.waiting  { background: #fff3cd; color: #856404; border: 1px solid #ffc107; }
        .status-pill.approved { background: #d1edda; color: #155724; border: 1px solid #28a745; }
        .status-pill.rejected { background: #f8d7da; color: #842029; border: 1px solid #dc3545; }

        .note-box { border-radius: 10px; padding: 14px 16px; font-size: .85rem; line-height: 1.5; margin-top: 16px; border-left: 3px solid; }
        .note-box.waiting  { background: #fffde7; border-color: #ffc107; color: #6d4c00; }
        .note-box.approved { background: #f0fdf4; border-color: #28a745; color: #14532d; }
        .note-box.rejected { background: #fff5f5; border-color: #dc3545; color: #7f1d1d; }

        .btn-print, .btn-action-trigger { background: var(--navy); color: #fff; border: none; border-radius: 10px; padding: 10px 22px; font-weight: 600; font-size: .9rem; display: inline-flex; align-items: center; gap: 8px; margin-top: 14px; width: 100%; justify-content: center; text-decoration: none; cursor: pointer; }
        .btn-print:hover, .btn-action-trigger:hover { background: #2d3561; color: #fff; }
        .btn-action-trigger.btn-warning-custom { background: #F4C542; color: #333; }
        .btn-action-trigger.btn-warning-custom:hover { background: #dfb233; }

        /* ─── STAR RATING ULASAN FORM ─── */
        .star-rating { display: flex; direction: row-reverse; justify-content: flex-end; gap: 4px; margin: .4rem 0 .8rem; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 1.6rem; color: #DDD; cursor: pointer; }
        .star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color: #F4C542; }

        @media print {
            body * { visibility: hidden !important; }
            #printReceipt, #printReceipt * { visibility: visible !important; }
            #printReceipt { position: fixed !important; top: 0; left: 0; width: 100%; min-height: 100vh; background: #fff !important; z-index: 99999; display: block !important; }
        }
        #printReceipt { display: none; }
        .receipt-paper { max-width: 420px; margin: 40px auto; background: #fff; border: 1px dashed #ccc; border-radius: 12px; padding: 36px 32px; }
        .receipt-header { text-align: center; margin-bottom: 24px; }
        .receipt-brand { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 900; color: var(--navy); }
        .receipt-subtitle { font-size: .8rem; color: #888; margin-top: 2px; }
        .receipt-divider { border: none; border-top: 1px dashed #ccc; margin: 16px 0; }
        .receipt-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: .88rem; }
        .receipt-row span:first-child { color: #777; }
        .receipt-row span:last-child { font-weight: 600; color: #111; text-align: right; max-width: 60%; }
        .receipt-approved-badge { text-align: center; margin-top: 20px; padding: 10px; background: var(--green-bg); border-radius: 10px; color: var(--green); font-weight: 700; font-size: .9rem; }
        .receipt-footer { text-align: center; margin-top: 24px; font-size: .75rem; color: #aaa; }

        @keyframes fadeDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes modalPop { from { opacity: 0; transform: scale(.88); } to { opacity: 1; transform: scale(1); } }
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity .5s ease, transform .5s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .modal-backdrop { backdrop-filter: blur(4px); background: rgba(0,0,0,.4) !important; opacity: 1 !important; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar-bookloop d-flex align-items-center justify-content-between">
    <a href="{{ url('/dashboard') }}" class="brand">
        <span class="brand-icon">📚</span> BookLoop
    </a>
    <div class="nav-links d-flex gap-1 d-none d-md-flex">
        <a href="{{ url('/dashboard') }}">home</a>
        <a href="{{ route('catalog.index') }}">catalog</a>
        <a href="{{ route('history.index') }}" class="active">history</a>
    </div>
    <div class="avatar-wrap">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->NamaLengkap) }}&background=C8702A&color=fff" alt="User Avatar">
    </div>
</nav>

<div class="container">

    {{-- Page Header --}}
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <h1 class="page-title">Borrowing history</h1>
        <div class="search-wrap">
            <input type="text" id="searchInput" placeholder="Search books…" autocomplete="off">
            <button class="search-btn"><i class="bi bi-search"></i></button>
        </div>
    </div>

    {{-- 📊 LOGIKA HITUNG DATA DARI DATABASE ASLI --}}
    @php
        $totalAll      = $peminjaman->count();
        $totalReturned = $peminjaman->where('StatusPeminjaman', 'Proses Kembali')->count(); 
        $totalFinished = $peminjaman->where('StatusPeminjaman', 'Dikembalikan')->count();
    @endphp

    {{-- TIGA KOTAK STATS FILTER --}}
    <div class="stat-section">
        <div class="row g-3">
            <div class="col-4">
                <div class="stat-card active" data-filter="all">
                    <span class="stat-number" id="statTotal">{{ $totalAll }}</span>
                    <div class="stat-label">Total borrowed</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card" data-filter="returned">
                    <span class="stat-number" id="statReturned">{{ $totalReturned }}</span>
                    <div class="stat-label">returned</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card" data-filter="finished">
                    <span class="stat-number" id="statFinished">{{ $totalFinished }}</span>
                    <div class="stat-label">finished</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-divider"></div>

    {{-- Book Cards Grid --}}
    <div class="books-grid" id="booksGrid">

        @forelse($peminjaman as $index => $p)
            @php
                // Menentukan pengelompokan filter klik kotak atas
                if ($p->StatusPeminjaman == 'Dikembalikan') {
                    $filterTag = 'finished';
                    $cardLabel = 'Finished';   
                    $modalVisual = 'approved'; 
                } elseif ($p->StatusPeminjaman == 'Proses Kembali') {
                    $filterTag = 'returned';
                    $cardLabel = 'Waiting';    
                    $modalVisual = 'rejected'; 
                } else {
                    $filterTag = 'all';        
                    $cardLabel = 'Borrowed';   
                    $modalVisual = 'waiting';  
                }

                $modalTransportData = [
                    'id' => $p->PeminjamanID,
                    'buku_id' => $p->BukuID,
                    'title' => $p->Buku->Judul ?? 'Buku Telah Dihapus',
                    'author' => $p->Buku->Penulis ?? 'Anonim',
                    'publisher' => 'Pustaka BookLoop',
                    'genre' => 'Koleksi Umum',
                    'borrower' => auth()->user()->NamaLengkap,
                    'borrow_date' => \Carbon\Carbon::parse($p->TanggalPeminjaman)->format('d May Y'),
                    'return_date' => \Carbon\Carbon::parse($p->TanggalPengembalian)->format('d May Y'),
                    'status_db' => $p->StatusPeminjaman, 
                    'visual_theme' => $modalVisual
                ];
            @endphp
            
            <div class="book-card reveal"
                 style="animation-delay: {{ $index * 0.08 }}s"
                 data-status="{{ $filterTag }}"
                 data-title="{{ strtolower($p->Buku->Judul ?? '') }} {{ strtolower($p->Buku->Penulis ?? '') }}">
                <div class="book-card-inner">
                    <div class="book-cover-placeholder">
                        <span>📖<br><small>{{ $p->Buku->Judul ?? '' }}</small></span>
                    </div>
                    <div class="book-info-overlay">
                        <div>
                            <div class="book-genre">KOLEKSI BUKU</div>
                            <div class="book-title-card">{{ $p->Buku->Judul ?? 'Tanpa Judul' }}</div>
                            <div class="book-author-card">{{ $p->Buku->Penulis ?? 'Anonim' }}</div>
                        </div>
                        <div class="book-card-bottom">
                            <div class="stars">★★★★★</div>
                            <div class="d-flex align-items-center gap-1">
                                <span class="badge-status-card">{{ $cardLabel }}</span>
                                <button class="btn-detail" onclick="openModal({{ json_encode($modalTransportData) }})">Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-4 shadow-sm" style="grid-column: 1/-1">
                <p class="text-muted m-0 small">Belum ada koleksi riwayat membaca yang terdata, Bung.</p>
            </div>
        @endforelse

    </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade modal-bookloop" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:520px">
        <div class="modal-content">

            <div class="modal-header-custom" id="modalHeader">
                <div class="book-cover-placeholder modal-cover-placeholder" id="modalCover">
                    <span id="modalCoverText">—</span>
                </div>
                <div>
                    <div class="modal-book-title" id="modalTitle">—</div>
                    <div class="modal-book-author" id="modalAuthor">—</div>
                    <span class="status-badge" id="modalStatusBadge">
                        <span class="dot"></span>
                        <span id="modalStatusText">—</span>
                    </span>
                </div>
                <button class="btn-back-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-chevron-left"></i>
                </button>
            </div>

            <div class="modal-body-custom">
                <table class="detail-table">
                    <tr><td>Transaction No.</td><td id="mdTrx">—</td></tr>
                    <tr><td>Book Title</td><td id="mdBookTitle">—</td></tr>
                    <tr><td>Author</td><td id="mdAuthor">—</td></tr>
                    <tr><td>Publisher</td><td id="mdPublisher">—</td></tr>
                    <tr><td>Borrower</td><td id="mdBorrower">—</td></tr>
                    <tr><td>Borrow Date</td><td id="mdBorrowDate">—</td></tr>
                    <tr><td>Return Date</td><td id="mdReturnDate">—</td></tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <span class="status-pill" id="mdStatusPill">
                                <span class="dot"></span>
                                <span id="mdStatusPillText">—</span>
                            </span>
                        </td>
                    </tr>
                </table>

                <div class="note-box" id="mdNoteBox">—</div>

                {{-- FORM INPUT ULASAN BINTANG --}}
                <div id="reviewBoxWrapper" style="display: none; border-top:1px dashed #ccc; padding-top:15px; margin-top:15px;">
                    <form action="{{ url('/user/ulasan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="BukuID" id="reviewFormBukuID">
                        <label class="small fw-bold text-dark d-block">Beri Ulasan Bintang & Komentar:</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="Rating" value="5"><label for="star5">★</label>
                            <input type="radio" id="star4" name="Rating" value="4"><label for="star4">★</label>
                            <input type="radio" id="star3" name="Rating" value="3"><label for="star3">★</label>
                            <input type="radio" id="star2" name="Rating" value="2"><label for="star2">★</label>
                            <input type="radio" id="star1" name="Rating" value="1"><label for="star1">★</label>
                        </div>
                        <textarea class="form-control form-control-sm" name="Ulasan" rows="2" placeholder="Share your thoughts about this book..." required></textarea>
                        <button type="submit" class="btn btn-sm btn-success w-100 mt-2 rounded-3 fw-bold">Submit Review</button>
                    </form>
                </div>

                <div id="dynamicActionArea"></div>

                <button class="btn-print d-none" id="btnPrint" onclick="printReceipt()">
                    <i class="bi bi-printer-fill"></i> Cetak Bukti Peminjaman
                </button>
            </div>

        </div>
    </div>
</div>

{{-- PRINT STRUK --}}
<div id="printReceipt">
    <div class="receipt-paper">
        <div class="receipt-header">
            <div class="receipt-brand">📚 BookLoop</div>
            <div class="receipt-subtitle">Bukti Peminjaman Buku</div>
        </div>
        <hr class="receipt-divider">
        <div class="receipt-row"><span>No. Transaksi</span><span id="rTrx">—</span></div>
        <div class="receipt-row"><span>Judul Buku</span><span id="rTitle">—</span></div>
        <div class="receipt-row"><span>Pengarang</span><span id="rAuthor">—</span></div>
        <div class="receipt-row"><span>Penerbit</span><span id="rPublisher">—</span></div>
        <div class="receipt-row"><span>Peminjam</span><span id="rBorrower">—</span></div>
        <div class="receipt-row"><span>Tanggal Pinjam</span><span id="rBorrowDate">—</span></div>
        <div class="receipt-row"><span>Tanggal Kembali</span><span id="rReturnDate">—</span></div>
        <hr class="receipt-divider">
        <div class="receipt-approved-badge">✅ Disetujui oleh Admin</div>
        <div class="receipt-footer">
            Dicetak pada: <span id="rPrintDate">—</span><br>
            Harap tunjukkan bukti ini saat mengambil atau mengembalikan buku fisik.
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
let activeBook = null;
const modalEl = document.getElementById('detailModal');
const bsModal  = new bootstrap.Modal(modalEl);

function openModal(book) {
    activeBook = book;
    const theme = book.visual_theme; 

    const header = document.getElementById('modalHeader');
    header.className = 'modal-header-custom status-' + theme;

    document.getElementById('modalCoverText').innerHTML = `<strong>${book.title}</strong>`;
    document.getElementById('modalTitle').textContent  = book.title;
    document.getElementById('modalAuthor').textContent = book.author;

    const badge = document.getElementById('modalStatusBadge');
    badge.className = 'status-badge ' + theme;
    document.getElementById('modalStatusText').textContent = statusLabelText(book.status_db, 'header');

    document.getElementById('mdTrx').textContent        = '#' + book.id;
    document.getElementById('mdBookTitle').textContent  = book.title;
    document.getElementById('mdAuthor').textContent     = book.author;
    document.getElementById('mdPublisher').textContent  = book.publisher;
    document.getElementById('mdBorrower').textContent   = book.borrower;
    document.getElementById('mdBorrowDate').textContent = book.borrow_date;
    document.getElementById('mdReturnDate').textContent = book.return_date;

    const pill = document.getElementById('mdStatusPill');
    pill.className = 'status-pill ' + theme;
    document.getElementById('mdStatusPillText').textContent = statusLabelText(book.status_db, 'pill');

    const noteBox = document.getElementById('mdNoteBox');
    noteBox.className = 'note-box ' + theme;
    noteBox.textContent = noteBodyText(book.status_db);

    const btnPrint = document.getElementById('btnPrint');
    const actionArea = document.getElementById('dynamicActionArea');
    const reviewBox = document.getElementById('reviewBoxWrapper');

    actionArea.innerHTML = '';
    reviewBox.style.display = 'none';

    if (book.status_db === 'Dipinjam') {
        btnPrint.classList.add('d-none');
        actionArea.innerHTML = `
            <form action="${window.location.origin}/user/pengembalian/${book.id}" method="POST">
                @csrf
                <button type="submit" class="btn-action-trigger btn-warning-custom fw-bold">↩️ Ajukan Pengembalian Buku</button>
            </form>
        `;
    } else if (book.status_db === 'Proses Kembali') {
        btnPrint.classList.add('d-none');
        actionArea.innerHTML = `<button class="btn-action-trigger bg-secondary text-white" disabled>⏳ Menunggu Validasi Fisik Buku</button>`;
    } else if (book.status_db === 'Dikembalikan') {
        btnPrint.classList.remove('d-none');
        document.getElementById('reviewFormBukuID').value = book.buku_id;
        reviewBox.style.display = 'block'; 
    }

    bsModal.show();
}

function statusLabelText(dbStatus, context) {
    if (context === 'header') {
        if (dbStatus === 'Dipinjam') return 'Waiting for admin to confirm';
        if (dbStatus === 'Proses Kembali') return 'Awaiting Return Confirmation';
        if (dbStatus === 'Dikembalikan') return 'Approved by Admin';
    }
    if (context === 'pill') {
        if (dbStatus === 'Dipinjam') return 'Awaiting';
        if (dbStatus === 'Proses Kembali') return 'Waiting Admin';
        if (dbStatus === 'Dikembalikan') return 'Approved';
    }
}

function noteBodyText(dbStatus) {
    if (dbStatus === 'Dipinjam') return 'Your request has been submitted. Please wait for the librarian\'s confirmation.';
    if (dbStatus === 'Proses Kembali') return 'You have submitted a return request. Please hand over the physical book to the staff.';
    if (dbStatus === 'Dikembalikan') return 'Your request has been approved! Transaction finished. Thank you for reading.';
}

function printReceipt() {
    if (!activeBook) return;
    document.getElementById('rTrx').textContent        = '#' + activeBook.id;
    document.getElementById('rTitle').textContent      = activeBook.title;
    document.getElementById('rAuthor').textContent     = activeBook.author;
    document.getElementById('rPublisher').textContent  = activeBook.publisher;
    document.getElementById('rBorrower').textContent   = activeBook.borrower;
    document.getElementById('rBorrowDate').textContent = activeBook.borrow_date;
    document.getElementById('rReturnDate').textContent = activeBook.return_date;

    const now = new Date();
    document.getElementById('rPrintDate').textContent  = now.toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric', hour:'2-digit', minute:'2-digit' });

    document.getElementById('printReceipt').style.display = 'block';
    window.print();
    document.getElementById('printReceipt').style.display = 'none';
}

document.querySelectorAll('.stat-card').forEach(box => {
    box.addEventListener('click', function() {
        document.querySelectorAll('.stat-card').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        document.querySelectorAll('#booksGrid .book-card').forEach(card => {
            if (filter === 'all' || card.dataset.status === filter) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('#booksGrid .book-card').forEach(card => {
        const haystack = card.dataset.title || '';
        card.style.display = haystack.includes(q) ? '' : 'none';
    });
});

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            revealObserver.unobserve(e.target);
        }
    });
}, { threshold: 0.15 });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

function animateCounter(el, target, duration = 1200) {
    let start = 0;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
        start = Math.min(start + step, target);
        el.textContent = Math.floor(start);
        if (start >= target) clearInterval(timer);
    }, 16);
}
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.stat-number').forEach(el => {
        const val = parseInt(el.textContent) || 0;
        animateCounter(el, val);
    });
});
</script>

</body>
</html>