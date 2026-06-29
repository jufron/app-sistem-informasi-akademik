<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
            'nisn'             => ['nullable', 'string', 'unique:siswa,nisn', 'max:50'],
            'nis'              => ['nullable', 'string', 'unique:siswa,nis', 'max:50'],
            'nama_lengkap'     => ['required', 'string', 'max:255'],
            'nama_panggilan'   => ['nullable', 'string', 'max:50'],
            'jenis_kelamin_id' => ['required', 'exists:jenis_kelamin,id'],
            'agama_id'         => ['required', 'exists:agama,id'],
            'tempat_lahir'     => ['required', 'string', 'max:100'],
            'tanggal_lahir'    => ['required', 'date'],
            'telepon'          => ['nullable', 'string', 'max:20'],
            'alamat'           => ['required', 'string'],
            'foto'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'status'           => ['required', 'in:Aktif,Nonaktif,Cuti'],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email sudah terdaftar.',
            'password.required'         => 'Password wajib diisi.',
            'password.min'              => 'Password minimal harus 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
            'nisn.unique'               => 'NISN sudah terdaftar.',
            'nis.unique'                => 'NIS sudah terdaftar.',
            'nama_lengkap.required'     => 'Nama lengkap wajib diisi.',
            'jenis_kelamin_id.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin_id.exists'   => 'Jenis kelamin tidak valid.',
            'agama_id.required'         => 'Agama wajib dipilih.',
            'agama_id.exists'           => 'Agama tidak valid.',
            'tempat_lahir.required'     => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required'    => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'        => 'Format tanggal lahir tidak valid.',
            'alamat.required'           => 'Alamat wajib diisi.',
            'foto.image'                => 'File harus berupa gambar.',
            'foto.mimes'                => 'Format gambar harus jpeg, png, jpg, webp, atau svg.',
            'foto.max'                  => 'Ukuran gambar maksimal 2MB.',
            'status.required'           => 'Status wajib dipilih.',
            'status.in'                 => 'Status tidak valid.',
        ];
    }
}
