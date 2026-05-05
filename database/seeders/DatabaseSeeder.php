<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admin;
use App\Models\siswa;
use App\Models\konten;
use App\Models\guru;
use App\Models\walas;
use App\Models\kelas;
use Illuminate\Support\Facades\DB;
use App\Models\kbm;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        admin::factory()->dataadmin1()->create();
        admin::factory()->dataadmin2()->create();
        konten::factory()->count(5)->create();

        $gurus = guru::factory(5)->create();

        //membuat 25 data untuk tabel siswa, dan disimpan di variabel objek siswas
        $siswas = siswa::factory(25)->create();

        //mengambil 3 data secara random dari variabel objek gurus
        $guruRandom = $gurus->random(3);

        //3 guru random dijadikan walas
        foreach ($guruRandom as $guru) {
            walas::factory()->create([
                'idguru' => $guru->idguru
            ]);
        }

        //mengambil data semua walas
        $waliKelasIds = walas::pluck('idwalas')->toArray();

        //mengacak urutan siswa
        $randomSiswas = $siswas->shuffle();

        //mendistribusikan siswa menjadi 3 kelompok sesuai jumlah wali kelas
        $chunks = $randomSiswas->chunk(ceil($randomSiswas->count() /
            count($waliKelasIds)));

        //perulangan tiap wali kelas dan siswanya
        foreach ($waliKelasIds as $index => $idwalas) {
            if (isset($chunks[$index])) {
                foreach ($chunks[$index] as $siswa) {
                    Kelas::create([
                        'idwalas' => $idwalas,
                        'idsiswa' => $siswa->id // <-- perbaiki di sini
                    ]);
                }
            }
        }

        // Seeder siswa dan walas harus dijalankan lebih dulu
        $siswa = siswa::first();
        $walas = walas::first();

        if ($siswa && $walas) {
            DB::table('datakelas')->insert([
                'idwalas' => $walas->idwalas,
                'idsiswa' => $siswa->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Buat satu jadwal pasti untuk setiap walas agar halaman Jadwal tidak kosong
        $allWalas = walas::all();
        foreach ($allWalas as $w) {
            // 1 slot jadwal contoh per walas (menghindari pelanggaran unique idguru)
            kbm::create([
                'idguru'  => $w->idguru,   // guru walas tersebut
                'idwalas' => $w->idwalas,  // kelas walas tsb
                'hari'    => 'Senin',
                'mulai'   => '07:00',
                'selesai' => '08:30',
            ]);
        }

        // Catatan: Tidak menambah data acak tambahan untuk menghindari bentrok unique idguru
    }
}
