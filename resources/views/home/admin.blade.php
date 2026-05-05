<!DOCTYPE html>
<html>
<head>
    <title>Home Admin</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Halo, {{ session('admin_username') }}</h2>
    <h3>Role anda : {{ ucfirst(session('admin_role')) }}</h3>
    <a href="{{ route('logout') }}">Logout</a>
    |
    <a href="{{ route('jadwal.index') }}">Lihat Jadwal</a>

    <h2>Daftar Siswa</h2>
    <a href="{{ route('siswa.create') }}">
        <button>+ Tambah Siswa</button>
    </a>
    <p><label>Cari Siswa: </label><input type="text" id="search" placeholder="Ketik nama..."></p>
    <table id="tabel-siswa" border="1" cellpadding="5" cellspacing="0">
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

    <script>
    $(document).ready(function(){
    function setLoading() {
        $('#tabel-siswa tbody').html('<tr><td colspan="4"><em>Memuat data...</em></td></tr>');
    }

    function renderTable(data) {
        let rows = '';
        if (!data || data.length === 0) {
        rows = '<tr><td colspan="4">Tidak ada data ditemukan</td></tr>';
        } else {
        data.forEach(function(s) {
            rows += `
            <tr>
                <td>${s.nama}</td>
                <td>${s.tb}</td>
                <td>${s.bb}</td>
                <td>
                <a href="{{ url('/siswa') }}/${s.id}/edit">Edit</a> |
                <form action="{{ url('/siswa') }}/${s.id}" method="POST" style="display:inline;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
                </td>
            </tr>
            `;
        });
        }
        $('#tabel-siswa tbody').html(rows);
    }

    function loadSiswa() {
      setLoading();
      $.ajax({
        url: "{{ route('siswa.data') }}",
        method: "GET",
        success: function(response) {
          renderTable(response);
        },
        error: function() {
          console.error('Gagal memuat data siswa.');
        }
      });
    }

    function searchSiswa(keyword) {
      setLoading();
      $.ajax({
        url: "{{ route('siswa.search') }}",
        method: "GET",
        data: { q: keyword },
        success: function(response) {
          renderTable(response);
        },
        error: function() {
          console.error('Gagal mencari data siswa.');
        }
      });
    }

    $('#search').on('keyup', function() {
      const keyword = $(this).val().trim();
      if (keyword.length > 0) {
        searchSiswa(keyword);
      } else {
        loadSiswa();
      }
    });

    // Initial: show loading then fetch via AJAX so data "hilang dulu" lalu muncul
    setLoading();
    loadSiswa();
    });
    </script>
        
</body>
</html>