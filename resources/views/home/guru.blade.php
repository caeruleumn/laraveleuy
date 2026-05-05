<!DOCTYPE html>
<html>
<head>
    <title>Home Guru</title>
</head>
<body>
    <h2>Halo, {{ session('admin_username') }}</h2>
    <h3>Role anda : {{ ucfirst(session('admin_role')) }}</h3>
    <a href="{{ route('logout') }}">Logout</a>
    |
    <a href="{{ route('jadwal.index') }}">Lihat Jadwal</a>

    @if ($profilGuru)
        <h4>Halo! Guru {{ $profilGuru->nama }}</h4>
        <h4>Mata Pelajaran : {{ $profilGuru->mapel ?? '-' }}</h4>
    @endif

    @if (!empty($tahunAjaran))
        <h4>Tahun Ajaran : {{ $tahunAjaran }}</h4>
    @endif

    @if ($listSiswa && $listSiswa->count())
        <h3>Daftar Siswa di Kelas</h3>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tinggi Badan</th>
                    <th>Berat Badan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listSiswa as $siswa)
                    <tr>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->tb }}</td>
                        <td>{{ $siswa->bb }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p><em>Tidak ada siswa di kelas ini.</em></p>
    @endif
</body>
</html>
