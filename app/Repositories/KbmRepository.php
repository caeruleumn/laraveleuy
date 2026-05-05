<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\kbm;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\KbmRepositoryInterface;

class KbmRepository implements KbmRepositoryInterface
{
    public function baseQueryForRole(?string $role, ?string $username)
    {
        $query = kbm::with(['guru', 'walas']);

        if ($role === 'guru' && $username) {
            $admin = Admin::where('username', $username)->first();
            if ($admin) {
                $profilGuru = Guru::where('id', $admin->id)->orWhere('idguru', $admin->id)->first();
                if ($profilGuru) {
                    $query->where('idguru', $profilGuru->idguru);
                } else {
                    $query->whereRaw('1=0');
                }
            } else {
                $query->whereRaw('1=0');
            }
        } elseif ($role === 'siswa' && $username) {
            $admin = Admin::where('username', $username)->first();
            if ($admin) {
                $kelasIds = Kelas::where('idsiswa', $admin->id)->pluck('idwalas');
                if ($kelasIds->count()) {
                    $query->whereIn('idwalas', $kelasIds);
                } else {
                    $query->whereRaw('1=0');
                }
            } else {
                $query->whereRaw('1=0');
            }
        }

        return $query;
    }

    public function listForRole(?string $role, ?string $username): Collection
    {
        return $this->baseQueryForRole($role, $username)->get();
    }
}
