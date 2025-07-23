{{-- resources/views/unauthorized.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title style="text-align: center;">Akses Ditolak</title>
</head>
<body style="text-align: center;">
    <h1>403 - Akses Ditolak</h1>
    <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="{{ url('/') }}">Kembali ke beranda</a>
</body>
</html>
