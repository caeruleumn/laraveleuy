<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Kbm;
use App\Models\Kelas;
use App\Models\Walas;
use App\Models\Guru;
use App\Contracts\Services\KbmServiceInterface;
use App\Http\Requests\KbmSearchRequest;

class KbmController extends Controller
{
    protected KbmServiceInterface $service;


    public function index(Request $request)
    {

        $role     = session('admin_role');
        $username = session('admin_username');

        // Start empty so the view shows a loading state, then AJAX will populate
        $jadwals    = collect();
        $profilGuru = null;
        $profilSiswa = null;
        $kelasAktif = null;

        // Keep role/profile info if needed on the page; actual data is dummy via AJAX
        if ($role === 'guru') {
            $admin = Admin::where('username', $username)->first();
            if ($admin) {
                $profilGuru = Guru::where('id', $admin->id)->orWhere('idguru', $admin->id)->first();
            }
        } elseif ($role === 'siswa') {
            $admin = Admin::where('username', $username)->first();
            if ($admin) {
                $kelasIds = Kelas::where('idsiswa', $admin->id)->pluck('idwalas');
                if ($kelasIds->count()) {
                    $kelasAktif = Walas::whereIn('idwalas', $kelasIds)->with('guru')->get();
                }
            }
        }

        return view('jadwal.index', compact('role', 'jadwals', 'profilGuru', 'profilSiswa', 'kelasAktif'));
    }

    public function data(Request $request)
    {
        $role     = session('admin_role');
        $username = session('admin_username');
        $items    = $this->service->listForRole($role, $username);

        $mapped = $items->map(function ($j) {
            $guruNama = optional($j->guru)->nama ?? '-';
            $mapel    = optional($j->guru)->mapel ?? '-';
            $jenjang  = optional($j->walas)->jenjang ?? '-';
            $namaKls  = optional($j->walas)->namakelas ?? '-';
            $thAjar   = optional($j->walas)->tahunajaran ?? '-';
            return [
                'id'      => $j->getKey(),
                'hari'    => $j->hari,
                'mulai'   => $j->mulai,
                'selesai' => $j->selesai,
                'guru'    => $guruNama,
                'mapel'   => $mapel,
                'kelas'   => sprintf('%s - %s (%s)', $jenjang, $namaKls, $thAjar),
            ];
        })->values();

        return response()->json($mapped);
    }

    public function search(KbmSearchRequest $request)
    {
        $role     = session('admin_role');
        $username = session('admin_username');
        $items    = $this->service->listForRole($role, $username);
        $filtered = $this->service->search($items, (string) ($request->validated()['q'] ?? ''));

        $mapped = $filtered->map(function ($j) {
            $guruNama = optional($j->guru)->nama ?? '-';
            $mapel    = optional($j->guru)->mapel ?? '-';
            $jenjang  = optional($j->walas)->jenjang ?? '-';
            $namaKls  = optional($j->walas)->namakelas ?? '-';
            $thAjar   = optional($j->walas)->tahunajaran ?? '-';
            return [
                'id'      => $j->getKey(),
                'hari'    => $j->hari,
                'mulai'   => $j->mulai,
                'selesai' => $j->selesai,
                'guru'    => $guruNama,
                'mapel'   => $mapel,
                'kelas'   => sprintf('%s - %s (%s)', $jenjang, $namaKls, $thAjar),
            ];
        })->values();

        return response()->json($mapped);
    }

    public function __construct(KbmServiceInterface $service)
    {
        $this->service = $service;
    }
}


