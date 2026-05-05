<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Models\siswa;
use App\Models\guru;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;


class adminController extends Controller
{

    public function formLogin()

    {
        return view('login');
    }

    public function prosesLogin(LoginRequest $request)
    {
        $validated = $request->validated();
        $admin = admin::where('username', $validated['username'])->first();

        if ($admin && Hash::check($validated['password'], $admin->password)) {
            // simpan ke session
            session([
                'admin_id'       => $admin->id,
                'admin_username' => $admin->username, // sesuai field di tabel admin
                'admin_role'     => $admin->role ?? 'guru', // sesuaikan dengan struktur anda
            ]);
            return redirect()->route('home');
        }
        return back()->with('error', 'Username atau password salah.');
    }

    public function formRegister()
    {
        return view('register');
    }

    public function prosesRegister(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            // simpan ke dataadmin
            $admin = admin::create([
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'role'     => $data['role'],
            ]);

             // Kalau role guru → simpan juga ke tabel dataguru
             if ($data['role'] === 'guru') {
                Guru::create([
                    'id'    => $admin->id,
                    'nama'  => $data['nama_guru'],
                    'mapel' => $data['mapel_guru'],
                ]);
            }
            
            if ($data['role'] === 'siswa') {
                Siswa::create([
                    'id'   => $admin->id,
                    'nama' => $data['nama_siswa'],
                    'tb'   => $data['tb_siswa'],
                    'bb'   => $data['bb_siswa'],
                ]);
            }

            return redirect()->back()->with('success', 'Registrasi berhasil!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }
    public function logout()
    {
        //hapus session
        session()->forget(['admin_id', 'admin_username']);
        return redirect()->route('landing');
    }
}
