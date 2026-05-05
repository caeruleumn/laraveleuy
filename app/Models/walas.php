<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Walas extends Model
{
    use HasFactory;

    protected $table = "datawalas";
    protected $primaryKey = "idwalas";
    public $timestamps = false; // kalau tabelnya tidak punya created_at & updated_at

    protected $fillable = [
        'jenjang',
        'namakelas',
        'tahunajaran',
        'idguru'
    ];

    // Relasi ke guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'idguru', 'idguru');
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'idwalas', 'idwalas');
    }

    // Relasi langsung ke siswa (lewat tabel kelas)
    public function siswa()
    {
        return $this->hasManyThrough(
            Siswa::class,   // model tujuan
            Kelas::class,   // model perantara
            'idwalas',      // FK di tabel datakelas
            'id',           // PK di tabel datasiswa
            'idwalas',      // PK di tabel walas
            'idsiswa'       // FK di tabel datakelas
        );
    }

    public function kbm()
    {
        return $this->hasMany(kbm::class);
    }
}
