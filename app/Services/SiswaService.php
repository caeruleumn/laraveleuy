<?php

namespace App\Services;

use App\Contracts\Services\SiswaServiceInterface;
use App\Contracts\Repositories\SiswaRepositoryInterface;
use App\Models\Siswa;

class SiswaService implements SiswaServiceInterface
{
    protected $repo;
    public function __construct(SiswaRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function createSiswa(array $data)
    {
        return $this->repo->create($data);
    }

    public function getById($id): ?Siswa
    {
        return $this->repo->findById($id);
    }

    public function updateSiswa($id, array $data): bool
    {
        $siswa = $this->repo->findById($id);
        if (!$siswa) {
            return false;
        }
        return $this->repo->update($siswa, $data);
    }
}
