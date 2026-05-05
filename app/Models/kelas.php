<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'datakelas';   // tabel di DB
    protected $primaryKey = 'idkelas';
    public $timestamps = false; // kalau di tabelmu tidak ada kolom created_at & updated_at

    protected $fillable = [
        'idwalas',
        'idsiswa'
    ];

    // Relasi ke tabel walas
    public function walas()
    {
        return $this->belongsTo(Walas::class, 'idwalas', 'idwalas');
    }

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'idsiswa', 'id');
    }
}
