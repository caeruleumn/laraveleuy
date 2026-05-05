<?php

namespace App\Services;

use App\Repositories\KbmRepository;
use App\Contracts\Services\KbmServiceInterface;
use App\Contracts\Repositories\KbmRepositoryInterface;
use Illuminate\Support\Collection;

class KbmService implements KbmServiceInterface
{
    public function __construct(private KbmRepositoryInterface $repo)
    {
    }

    public function listForRole(?string $role, ?string $username): Collection
    {
        return $this->repo->listForRole($role, $username);
    }

    public function search(Collection $items, string $q): Collection
    {
        $q = mb_strtolower(trim($q));
        if ($q === '') {
            return $items->values();
        }
        return $items->filter(function ($j) use ($q) {
            $hari    = mb_strtolower((string) ($j->hari ?? ''));
            $mulai   = mb_strtolower((string) ($j->mulai ?? ''));
            $selesai = mb_strtolower((string) ($j->selesai ?? ''));
            $guru    = mb_strtolower((string) (optional($j->guru)->nama ?? ''));
            $mapel   = mb_strtolower((string) (optional($j->guru)->mapel ?? ''));
            $jenjang = mb_strtolower((string) (optional($j->walas)->jenjang ?? ''));
            $namaKls = mb_strtolower((string) (optional($j->walas)->namakelas ?? ''));
            $thAjar  = mb_strtolower((string) (optional($j->walas)->tahunajaran ?? ''));
            return str_contains($hari, $q)
                || str_contains($mulai, $q)
                || str_contains($selesai, $q)
                || str_contains($guru, $q)
                || str_contains($mapel, $q)
                || str_contains($jenjang, $q)
                || str_contains($namaKls, $q)
                || str_contains($thAjar, $q);
        })->values();
    }
}
