<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    public function admin()
    {
        return $this->belongsTo(admin::class, 'id', 'id');
    }
    protected $table = 'datasiswa';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama',
        'tb',
        'bb',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class,'idsiswa','id');
    }
}
