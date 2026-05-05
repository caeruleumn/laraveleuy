<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'    => 'required|string|max:50|unique:dataadmin,username',
            'password'    => 'required|string|min:8',
            'role'        => 'required|string|in:admin,guru,siswa',
            'nama_guru'   => 'exclude_unless:role,guru|required|string|max:100',
            'mapel_guru'  => 'exclude_unless:role,guru|required|string|max:100',
            'nama_siswa'  => 'exclude_unless:role,siswa|required|string|max:100',
            'tb_siswa'    => 'exclude_unless:role,siswa|required|numeric',
            'bb_siswa'    => 'exclude_unless:role,siswa|required|numeric',
        ];
    }
}
