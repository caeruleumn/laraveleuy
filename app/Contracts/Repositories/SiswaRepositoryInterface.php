<?php

namespace App\Contracts\Repositories;

use App\Models\Siswa;

interface SiswaRepositoryInterface
{
    public function create(array $data);

    public function findById($id): ?Siswa;

    public function update(Siswa $siswa, array $data): bool;
}
