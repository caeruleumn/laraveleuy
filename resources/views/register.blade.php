<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script>
        function showChoice() {
            const role = document.querySelector('input[name="role"]:checked')?.value;
            document.getElementById('guruFields').style.display = (role === 'guru') ? 'block' : 'none';
            document.getElementById('siswaFields').style.display = (role === 'siswa') ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h2>Register</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
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
        <p>Username:</p>
        <input type="text" name="username" placeholder="Username" required><br>
        <p>Password:</p>
        <input type="password" name="password" placeholder="Password" required><br>

        <label><input type="radio" name="role" value="admin" onclick="showChoice()" checked> Admin</label>
        <label><input type="radio" name="role" value="guru" onclick="showChoice()"> Guru</label>
        <label><input type="radio" name="role" value="siswa" onclick="showChoice()"> Siswa</label>

        {{-- Field tambahan untuk Guru --}}
        <div id="guruFields" style="display:none;">
            <p>Nama Guru:</p>
            <input type="text" name="nama_guru" placeholder="Nama Guru"><br><br>

            <p>Mata Pelajaran:</p>
            <input type="text" name="mapel_guru" placeholder="Mata Pelajaran"><br><br>
        </div>

        {{-- Field tambahan untuk Siswa --}}
        <div id="siswaFields" style="display:none;">
            <p>Nama Siswa:</p>
            <input type="text" name="nama_siswa" placeholder="Nama Siswa"><br><br>

            <p>Tinggi Badan:</p>
            <input type="number" name="tb_siswa" placeholder="Tinggi Badan"><br><br>

            <p>Berat Badan:</p>
            <input type="number" name="bb_siswa" placeholder="Berat Badan"><br><br>
        </div>
        <br>
        <br>
        <button type="submit">Register</button>
    </form>

    <p hidden>
    ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣀⣤⡤⣦⣤⡴⣲⣖⠶⡴⣤⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣠⣴⢻⣻⣝⡮⢷⣳⢮⣗⢯⣞⣻⣽⣶⣛⢿⣲⢦⣄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⣤⢶⢯⣳⡭⣟⡶⣝⡾⣻⢼⡳⣞⢯⡞⣵⣻⠾⣭⢷⣟⣮⢗⣻⢦⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⡾⣯⢞⡽⣞⢷⣻⡝⣞⣧⢿⣱⢯⣳⢯⣳⢯⣳⡭⣟⣭⢿⣻⢿⣭⣛⣮⢟⣦⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣀⡤⠔⢚⣭⡺⣝⣳⡽⢾⣽⢻⣄⢷⣏⡿⣽⢾⣹⡞⣵⡻⣼⡳⢧⣟⢮⣳⢯⡽⣻⣖⣻⡼⣫⣞⣵⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⠖⠋⠀⢠⣴⢻⣖⣻⣭⢷⣻⣟⢮⣟⣼⠜⢤⣿⢯⣳⢧⣟⣳⢿⣱⣿⣻⢼⣫⢗⡯⡾⣽⡞⣵⣏⢷⡞⣵⣳⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⠊⠀⠀⢀⣼⢻⡼⣳⡽⣶⣻⢿⣟⢮⣻⠎⠁⠀⢸⡟⣮⢗⡯⣞⠿⣏⡷⣻⣯⡗⣯⢾⣹⡽⣞⣿⢳⡞⣯⢞⣳⡽⡄⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠸⠀⠀⢀⡼⣇⣿⢣⣟⣿⣟⣻⣿⣜⡿⠃⠀⠀⠀⣿⢻⣇⡿⣻⣼⠃⣟⣧⢟⣧⢿⣣⢟⣧⢻⣿⢟⣧⠿⣜⡿⣣⠿⡇⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣼⣻⡼⣣⣿⣛⢾⣼⣿⡷⡞⠀⠀⠀⠀⠀⣾⣏⡾⣵⣛⡎⠀⠹⣞⢯⣻⢾⣱⡟⣮⢟⡼⣿⣺⡝⣯⢞⡽⣛⡇⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠘⠁⢳⣽⣛⣶⣿⣿⣿⣿⡟⠀⠀⣠⣤⡀⠈⡏⣽⡞⣵⣻⠀⠀⠀⠸⣯⡽⣟⡶⣫⢷⣫⢟⣿⣱⢯⣳⢏⡿⣹⠃⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⢀⠀⠀⠀⠀⠀⠀⢠⡞⣧⣿⣿⣿⣿⣿⣿⡇⢠⡞⢠⣖⢓⠉⠀⠘⡽⣧⢿⠀⠠⠀⠀⢸⣳⣯⢗⣯⣳⣯⠾⣽⣫⣞⡷⢯⣝⣿⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢀⢀⡁⡆⠀⠀⠀⠀⢀⣾⣿⣿⣿⣿⣿⣿⣿⣿⡇⠘⠂⣿⣿⡟⠀⠀⠀⠙⣞⣏⢠⢚⣛⡻⣆⠳⣯⡟⡶⣽⣷⡻⣽⣳⡾⣽⢫⡾⣯⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⡰⠨⠀⡞⠈⠁⠀⠀⠀⠀⣸⣿⣿⣿⡿⠛⠋⣱⣿⣿⡇⠀⠁⠿⠟⠀⠀⠀⠀⠀⠈⠹⣰⣿⣿⠈⡞⡇⣝⡾⡽⣽⣷⡻⣽⢿⡝⣾⣹⣽⣳⡆⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠄⡄⣤⠙⠀⡆⠀⠀⠀⠀⠉⣼⣿⠟⠁⠀⢰⣿⣿⣿⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣿⣿⣿⡿⢁⢇⣿⢺⣝⣿⣿⣽⢋⣟⡞⣧⠷⣏⣷⠃⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠨⢁⠂⠀⡀⠁⠀⠀⠀⠀⠀⣻⠏⠀⠀⠀⠀⠻⣿⣿⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠛⠿⠟⠁⢠⣿⡝⣧⣿⣻⠾⠇⢨⣞⡽⣣⣟⡿⢾⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠠⠀⠀⠀⠠⢢⡀⠀⠀⠀⠀⠸⠀⠀⠀⠀⠀⢸⡟⣽⣷⣄⠀⠀⠀⢠⣀⡀⢀⠀⠀⠀⠀⠀⢀⣴⡿⣿⡾⢿⡼⢃⢃⣴⢻⣜⢷⣻⣼⣟⠏⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⢀⠀⠀⣡⣿⣿⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⣸⣿⣿⣿⣷⣄⠀⠸⣯⢝⣻⠀⠀⠀⣠⣖⡟⣮⢿⣏⣿⣿⢷⣏⠿⣜⡯⣞⢯⡷⡞⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⢀⡁⢁⣼⣿⣿⣿⣇⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣿⣿⣿⣿⣿⣿⣧⡀⠁⠉⠁⠀⣠⡟⣷⢺⣝⣯⣷⣻⣛⣮⢷⣺⣻⡝⡾⣭⢿⠝⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⢸⣷⣾⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀⠀⢀⣤⣾⣿⣿⣿⣿⣿⣿⣿⠋⢲⠒⢂⣿⢳⣯⡽⠗⣺⢷⣣⢷⣫⣾⣷⣟⣧⠿⠙⠁⠋⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠
⠐⢿⣿⣿⣿⣿⣿⣿⣿⣦⣤⠀⠀⠀⣠⣴⣿⣿⣿⣿⣿⣿⣿⣿⠿⢡⣤⣂⠒⠟⠚⠉⠀⢀⡰⣯⣳⣿⣿⣿⣿⣿⣾⣿⣄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⢄⡎⣿⣟
⠀⠀⠙⣿⣿⣿⣿⣿⣿⣿⣿⣾⣿⣾⣿⣿⣿⣿⣿⣿⣿⣿⠛⢠⣴⢧⡙⡟⡀⠀⠀⠂⢈⣤⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣧⡀⠀⠀⠀⠀⠀⢀⡠⣠⣦⣾⣻⣿⡇⢸⢻
⠀⠀⠀⠘⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⢰⠟⡎⡄⢃⢸⠰⠀⢀⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣆⡀⣠⣴⡵⣿⣷⡿⣿⣿⣽⢿⣧⠸⡏
⠀⠀⠀⠀⠘⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⢿⣿⠧⢾⣼⠸⠀⢸⠀⣇⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢿⣻⣯⠺⣾⣽⣿⣿⣽⣿⣿⣯⡿⣿⣿⡿⡀⣷
⠀⠀⠀⠀⠀⠈⢻⣿⣿⣿⣿⣿⣿⣿⣿⡟⠛⠁⠀⡟⢡⣾⣿⠁⡇⡇⡎⢰⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢫⡏⢲⣯⠉⢨⠀⢸⣿⣿⣽⣿⣿⣽⣿⣿⣽⣿⣿⣷⡟
⠀⠀⠀⠀⠀⠀⠀⠹⣿⣿⣿⡿⠿⠋⠉⠀⢀⣠⣴⡵⠿⣿⣿⢘⢹⣈⣰⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣻⣯⣷⠟⠙⠀⣼⠋⠀⠇⠀⢰⣿⣿⣷⣻⣿⣷⣿⡷⠿⠛⠉⠁⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠈⠋⠁⠀⠀⠀⠀⡴⣿⠟⢿⣿⣶⡀⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣟⣿⣿⣻⠋⣟⣿⣟⠇⠂⠰⡇⠀⢈⠀⠀⢸⣷⣿⠷⠟⠛⠉⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣾⣶⣾⣝⣼⣿⣿⣿⠆⢹⣿⣯⣽⣿⣿⣯⣿⣾⠉⣿⣿⣿⡀⢸⣿⠏⢀⡇⠀⡁⠀⠈⠆⠀⠈⠣⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⣠⣾⣿⣿⣾⣿⣿⣶⣿⣿⣿⣿⣿⣿⣿⣿⣿⣧⣼⣿⣿⣿⣯⢿⣿⣿⣯⡀⠿⣿⣯⣷⣾⣿⣄⡀⠙⠀⠃⠀⠀⠀⠀⠀⡠⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⣾⣿⣿⣿⡿⣟⠻⡛⢿⣿⡟⣉⠙⣿⣿⣿⣿⣿⢻⣿⢸⣿⣿⣿⠸⣿⣻⣿⣿⣿⣿⣯⣷⣿⣿⣿⣧⠀⠀⠀⠀⠀⠀⠀⣄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢀⣿⣿⣿⠏⠒⢀⠤⡴⠀⠈⡇⢒⣶⣿⣯⣿⣸⣿⢸⡿⣌⣿⣼⣿⢿⣿⣯⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠄⠀⠀⠀⠀⠀⣺⣿⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢸⣿⣿⢇⣘⠧⣟⠁⢴⡃⠕⢧⠐⡛⣿⡟⣿⣯⣿⣷⣽⣿⣽⣾⣿⣿⣿⣿⣿⣿⣿⣿⡿⠛⢹⣿⣿⣇⠀⠂⠀⠀⠔⣠⣿⠇⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⣿⣿⣿⢹⠿⣧⢗⠀⠟⡇⠂⢸⡀⢶⢳⠿⠛⣽⢫⣽⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡀⠀⠈⣿⣿⣿⣷⣶⣶⣶⣾⣿⠏
    </p>
</body>
</html>
