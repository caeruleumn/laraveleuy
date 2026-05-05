<?php

namespace App\Repositories;

use App\Models\Siswa;
use App\Contracts\Repositories\SiswaRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class SiswaRepository implements SiswaRepositoryInterface
{
    public function create(array $data)
    {
        $admin = \App\Models\Admin::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => 'siswa',
        ]);
        $siswa = \App\Models\Siswa::create([
            'id' => $admin->id,
            'nama' => $data['nama'],
            'tb' => $data['tb'],

            'bb' => $data['bb'],
        ]);
        return $siswa;
    }

    public function findById($id): ?Siswa
    {
        return Siswa::find($id);
    }

    public function update(Siswa $siswa, array $data): bool
    {
        return $siswa->update($data);
    }
}