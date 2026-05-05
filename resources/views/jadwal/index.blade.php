<!DOCTYPE html>
<html>
<head>
    <title>Jadwal</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h2>Jadwal KBM</h2>
    <p>Role: {{ ucfirst($role) }}</p>
    <p><a href="{{ route('home') }}">Kembali ke Home</a></p>
    

    @if ($role === 'guru' && $profilGuru)
        <h3>Guru: {{ $profilGuru->nama }} ({{ $profilGuru->mapel ?? '-' }})</h3>
    @endif

    @if ($role === 'siswa' && $kelasAktif && $kelasAktif->count())
        <h3>Kelas Aktif:</h3>
        <ul>
            @foreach ($kelasAktif as $k)
                <li>
                    {{ $k->jenjang }} - {{ $k->namakelas }} | Wali Kelas: {{ optional($k->guru)->nama ?? '-' }} | Tahun Ajaran: {{ $k->tahunajaran ?? '-' }}
                </li>
            @endforeach
        </ul>
    @endif

    <p><label>Cari Jadwal: </label><input type="text" id="search" placeholder="Ketik hari/guru/mapel/kelas..."></p>

    <table id="tabel-jadwal" border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Guru</th>
                <th>Mapel</th>
                <th>Kelas (Walas)</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($jadwals) && collect($jadwals)->count())
                @foreach (collect($jadwals)->sortBy(['hari','mulai']) as $j)
                    <tr>
                        <td>{{ $j['hari'] ?? (is_object($j) ? $j->hari : '') }}</td>
                        <td>{{ $j['mulai'] ?? (is_object($j) ? $j->mulai : '') }}</td>
                        <td>{{ $j['selesai'] ?? (is_object($j) ? $j->selesai : '') }}</td>
                        <td>{{ $j['guru'] ?? (is_object($j) ? (optional($j->guru)->nama ?? '-') : '') }}</td>
                        <td>{{ $j['mapel'] ?? (is_object($j) ? (optional($j->guru)->mapel ?? '-') : '') }}</td>
                        <td>
                            @php
                                $kelasStr = null;
                                if (is_array($j)) {
                                    $kelasStr = $j['kelas'] ?? null;
                                } elseif (is_object($j)) {
                                    $kelasStr = $j->walas ? ($j->walas->jenjang.' - '.$j->walas->namakelas.' ('.$j->walas->tahunajaran.')') : '-';
                                }
                            @endphp
                            {{ $kelasStr ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6"><em>Memuat jadwal...</em></td>
                </tr>
            @endif
        </tbody>
    </table>

    <script>
    $(document).ready(function(){
        function setLoading() {
            $('#tabel-jadwal tbody').html('<tr><td colspan="6"><em>Memuat jadwal...</em></td></tr>');
        }

        function renderTable(data) {
            let rows = '';
            const list = Array.isArray(data) ? data : [];
            if (list.length === 0) {
                rows = '<tr><td colspan="6"><em>Tidak ada jadwal.</em></td></tr>';
            } else {
                // Optional: order by weekdays then time
                const order = { 'Senin':1,'Selasa':2,'Rabu':3,'Kamis':4,'Jumat':5 };
                list.sort(function(a,b){
                    const da = order[a.hari] || 99;
                    const db = order[b.hari] || 99;
                    if (da !== db) return da - db;
                    return (a.mulai||'').localeCompare(b.mulai||'');
                });
                list.forEach(function(j){
                    rows += `
                    <tr>
                        <td>${j.hari}</td>
                        <td>${j.mulai}</td>
                        <td>${j.selesai}</td>
                        <td>${j.guru}</td>
                        <td>${j.mapel}</td>
                        <td>${j.kelas}</td>
                    </tr>`;
                });
            }
            $('#tabel-jadwal tbody').html(rows);
        }

        function loadJadwal() {
            setLoading();
            $.ajax({
                url: "{{ route('jadwal.data') }}",
                method: "GET",
                success: function(response) {
                    renderTable(response);
                },
                error: function() {
                    alert('Gagal memuat data jadwal.');
                }
            });
        }

        function searchJadwal(keyword) {
            setLoading();
            $.ajax({
                url: "{{ route('jadwal.search') }}",
                method: "GET",
                data: { q: keyword },
                success: function(response) {
                    renderTable(response);
                },
                error: function() {
                    console.error('Gagal mencari data jadwal.');
                }
            });
        }

        $('#search').on('keyup', function() {
            const keyword = $(this).val().trim();
            if (keyword.length > 0) {
                searchJadwal(keyword);
            } else {
                loadJadwal();
            }
        });

        setLoading();
        loadJadwal();
    });
    </script>
</body>
</html>
