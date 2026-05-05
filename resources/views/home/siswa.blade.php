<!DOCTYPE html>
<html>
<head>
    <title>Home Siswa</title>
</head>
<body>
    <h2>Halo, {{ session('admin_username') }}</h2>
    <h3>Role anda : {{ ucfirst(session('admin_role')) }}</h3>
    <a href="{{ route('logout') }}">Logout</a>
    |
    <a href="{{ route('jadwal.index') }}">Lihat Jadwal</a>

    @if ($profilSiswa)
        <h4>Halo! Siswa {{ $profilSiswa->nama }}</h4>
        <h4>Tinggi Badan : {{ $profilSiswa->tb }}</h4>
        <h4>Berat Badan : {{ $profilSiswa->bb }}</h4>
    @endif

    @if ($kelas)
        <h4>Kelas : {{ optional($kelas->walas)->namakelas ?? '-' }}</h4>
        <h4>Wali Kelas : {{ optional($kelas->walas->guru)->nama ?? '-' }}</h4>
        <h4>Tahun Ajaran : {{ optional($kelas->walas)->tahunajaran ?? '-' }}</h4>
    @endif
</body>
</html>
