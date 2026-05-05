<?php

namespace App\Contracts\Services;

use App\Models\Siswa;

interface SiswaServiceInterface
{
    public function createSiswa(array $data);

    public function getById($id): ?Siswa;

    public function updateSiswa($id, array $data): bool;
}
