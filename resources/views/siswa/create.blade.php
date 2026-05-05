<!DOCTYPE html>
<html>

<head>
    <title>Tambah Siswa</title>
</head>

<body>
    <h2>Tambah Siswa</h2>
    <form method="POST" action="{{ route('siswa.store') }}">
        @csrf
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input type="hidden" name="role" value="siswa">
        <input type="text" name="nama" placeholder="Nama" required><br>
        <input type="number" name="tb" placeholder="Tinggi Badan (cm)" required><br>
        <input type="number" name="bb" placeholder="Berat Badan (kg)" required><br>
        <br><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Simpan</button>
        <a href="{{ route('home') }}">Batal</a>
    </form>
</body>

</html>