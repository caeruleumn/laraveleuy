<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface KbmRepositoryInterface
{
    public function baseQueryForRole(?string $role, ?string $username);

    public function listForRole(?string $role, ?string $username): Collection;
}
