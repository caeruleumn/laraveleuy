<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <h2>Halo, {{ session('admin_username') }}</h2>
    <h3>Role anda : {{ ucfirst(session('admin_role')) }}</h3>
    <a href="{{ route('logout') }}">Logout</a>
    |
    <a href="{{ route('jadwal.index') }}">Lihat Jadwal</a>

    {{-- Profil Guru --}}
    @if ($role === 'guru')
        <h4>Halo! Guru {{ $profilGuru->nama }}</h4>
        <h4>Mata Pelajaran : {{ $profilGuru->mapel ?? '-' }}</h4>

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
    @endif

    {{-- Profil Siswa --}}
    @if ($role === 'siswa')
        <h4>Halo! Siswa {{ $profilSiswa->nama }}</h4>
        <h4>Tinggi Badan : {{ $profilSiswa->tb }}</h4>

        <h4>Berat Badan : {{ $profilSiswa->bb }}</h4>
        @if ($kelas)
            <h4>Kelas : {{ optional($kelas->walas)->namakelas ?? '-' }}</h4>
            <h4>Wali Kelas : {{ optional($kelas->walas->guru)->nama ?? '-' }}</h4>
            <h4>Tahun Ajaran : {{ optional($kelas->walas)->tahunajaran ?? '-' }}</h4>
        @endif
    @endif

    {{-- Daftar Siswa & Guru hanya untuk admin --}}
    @if ($role === 'admin')
        <h2>Daftar Siswa</h2>
        <a href="{{ route('siswa.create') }}">
            <button>+ Tambah Siswa</button>
        </a>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tinggi Badan</th>
                    <th>Berat Badan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listSiswa as $siswa)
                    <tr>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->tb }}</td>
                        <td>{{ $siswa->bb }}</td>
                        <td>
                            <a href="{{ route('siswa.edit', $siswa->id) }}">Edit</a> |
                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"><em>Belum ada siswa</em></td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h2>Daftar Guru</h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Mata Pelajaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listGuru as $guru)
                    <tr>
                        <td>{{ $guru->nama }}</td>
                        <td>{{ $guru->mapel }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2"><em>Belum ada guru</em></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    
</body>

</html>