<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Layanan - CatCare</title>
</head>
<body>
    <h1>Daftar Layanan Penitipan Kucing</h1>

    @forelse ($layanans as $layanan)
        <div>
            <h2>{{ $layanan->nama_layanan }}</h2>
            <p>{{ $layanan->deskripsi }}</p>
            <p>Harga: Rp{{ number_format($layanan->harga, 0, ',', '.') }} per hari</p>
        </div>
        <hr>
    @empty
        <p>Belum ada layanan yang tersedia.</p>
    @endforelse
</body>
</html>