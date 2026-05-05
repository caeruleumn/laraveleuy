<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\kontenController;
use App\Http\Controllers\KbmController;

Route::get('/', [kontenController::class, 'landing'])->name('landing');
Route::get('/login', [adminController::class, 'formLogin'])->name('login');
Route::post('/login', [adminController::class, 'prosesLogin'])->name('login.post');
    // Admin-only
    Route::middleware('cekrole:admin')->group(function () {
        Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::post('/siswa/{id}/update', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        Route::get('/siswa/data', [SiswaController::class, 'getData'])->name('siswa.data');
        Route::get('/siswa/search', [SiswaController::class, 'search'])->name('siswa.search');
    });
Route::middleware('ceklogin')->group(function () {
    // Redirector: arahkan ke home sesuai role yang login
    Route::get('/home', [SiswaController::class, 'home'])->name('home');



    // Halaman yang dapat diakses semua role yang login (admin, guru, siswa)
    Route::middleware('cekrole:admin,guru,siswa')->group(function () {
        Route::get('/jadwal', [KbmController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/data', [KbmController::class, 'data'])->name('jadwal.data');
        Route::get('/jadwal/search', [KbmController::class, 'search'])->name('jadwal.search');
        Route::get('/logout', [adminController::class, 'logout'])->name('logout');
    });

    // Home khusus per role
    Route::middleware('cekrole:admin')->get('/home/admin', [SiswaController::class, 'homeAdmin'])->name('home.admin');
    Route::middleware('cekrole:guru')->get('/home/guru', [SiswaController::class, 'homeGuru'])->name('home.guru');
    Route::middleware('cekrole:siswa')->get('/home/siswa', [SiswaController::class, 'homeSiswa'])->name('home.siswa');
});
Route::get('/register', [adminController::class, 'formRegister'])->name('register');
Route::post('/register', [adminController::class, 'prosesRegister'])->name('register.post');
Route::get('/detil/{id}', [kontenController::class, 'detil'])->name('detil');