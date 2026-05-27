<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Buku</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">LAPORAN DATA BUKU PERPUSTAKAAN DIGITAL</h2>
    <hr>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buku as $b)
            <tr>
                <td>{{ $b->id }}</td><td>{{ $b->Judul }}</td><td>{{ $b->Penulis }}</td><td>{{ $b->Penerbit }}</td><td>{{ $b->TahunTerbit }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.print(); // Trik pemicu mesin print otomatis browser
    </script>
</body>
</html>