<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Walas;
use App\Models\Admin;
use App\Contracts\Services\SiswaServiceInterface;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;

class SiswaController extends Controller
{
    protected $service;

    public function home()
    {
        $role = session('admin_role');
        if ($role === 'admin') {
            return redirect()->route('home.admin');
        }
        if ($role === 'guru') {
            return redirect()->route('home.guru');
        }
        if ($role === 'siswa') {
            return redirect()->route('home.siswa');
        }
        return redirect()->route('login');
    }

    public function getData(){
        $siswa = Siswa::all();
        return response()->json($siswa);
    }

    public function search(Request $request)
    {
        $q = (string) $request->input('q', '');
        $keyword = strtolower($q);
        if ($keyword === '') {
            return response()->json(Siswa::all());
        }
        $siswa = Siswa::whereRaw('LOWER(nama) LIKE ?', ["%{$keyword}%"]) ->get();
        return response()->json($siswa);
    }

    public function homeAdmin()
    {
        $listSiswa = Siswa::all();
        $listGuru  = Guru::all();
        return view('home.admin', compact('listSiswa', 'listGuru'));
    }

    public function homeGuru()
    {
        $username   = session('admin_username');
        $profilGuru = null;
        $listSiswa  = collect();
        $tahunAjaran = null;
        $walas = null;
        $kelas = null;

        $admin = Admin::where('username', $username)->first();
        if ($admin) {
            $profilGuru = Guru::where('id', $admin->id)->first();
            if ($profilGuru) {
                $walas = Walas::where('idguru', $profilGuru->idguru)
                    ->with('kelas.siswa')
                    ->first();
                if ($walas && $walas->kelas->count()) {
                    $tahunAjaran = $walas->tahunajaran ?? '-';
                    $kelas       = $walas->kelas->first();
                    $listSiswa   = $walas->kelas->map->siswa->filter();
                }
            }
        }

        return view('home.guru', compact('profilGuru', 'listSiswa', 'tahunAjaran', 'walas', 'kelas'));
    }

    public function homeSiswa()
    {
        $username    = session('admin_username');
        $profilSiswa = null;
        $kelas       = null;
        $walas       = null;
        $tahunAjaran = null;

        $admin = Admin::where('username', $username)->first();
        if ($admin) {
            $profilSiswa = Siswa::where('id', $admin->id)->first();
            if ($profilSiswa) {
                $kelas = Kelas::with('walas.guru')
                    ->where('idsiswa', $profilSiswa->id)
                    ->first();
                if ($kelas && $kelas->walas) {
                    $walas       = $kelas->walas;
                    $tahunAjaran = $walas->tahunajaran ?? '-';
                }
            }
        }

        return view('home.siswa', compact('profilSiswa', 'kelas', 'walas', 'tahunAjaran'));
    }

    // CRUD Siswa
    public function create()
    {
        return view('siswa.create');
    }

    public function store(StoreSiswaRequest $request)
    {
        $this->service->createSiswa($request->validated());
        return redirect()->route('home')->with('success', 'Data siswa berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $siswa = $this->service->getById($id);
        if (!$siswa) {
            abort(404);
        }
        return view('siswa.edit', compact('siswa'));
    }

    public function update(UpdateSiswaRequest $request, $id)
    {
        $validated = $request->validated();
        $ok = $this->service->updateSiswa($id, $validated);
        if (!$ok) {
            return back()->with('error', 'Siswa tidak ditemukan.');
        }
        return redirect()->route('home')->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('home')->with('success', 'Data siswa berhasil dihapus!');
    }

    public function __construct(SiswaServiceInterface $service)
    {
        $this->service = $service;
    }
}
