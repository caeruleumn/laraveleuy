<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface KbmServiceInterface
{
    public function listForRole(?string $role, ?string $username): Collection;

    public function search(Collection $items, string $q): Collection;
}
