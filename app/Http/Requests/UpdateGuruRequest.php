<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGuruRequest extends FormRequest
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
        $guru = $this->route('guru');
        $guruId = $guru ? $guru->id : null;
        $userId = $guru ? $guru->user_id : null;

        return [
            'email'                => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'password'             => ['nullable', 'string', 'min:8'],
            'nip'                  => ['nullable', 'string', 'max:50', 'unique:guru,nip,' . $guruId],
            'nama_lengkap'         => ['required', 'string', 'max:255'],
            'nama_panggilan'       => ['nullable', 'string', 'max:50'],
            'jenis_kelamin_id'     => ['required', 'exists:jenis_kelamin,id'],
            'agama_id'             => ['required', 'exists:agama,id'],
            'tempat_lahir'         => ['required', 'string', 'max:100'],
            'tanggal_lahir'        => ['required', 'date'],
            'telepon'              => ['required', 'string', 'max:20'],
            'alamat'               => ['required', 'string'],
            'tipe'                 => [
                'required',
                'string',
                'in:Bukan Wali Kelas,Wali Kelas,Kepala Sekolah',
                function ($attribute, $value, $fail) use ($guruId) {
                    if ($value === 'Kepala Sekolah') {
                        $exists = \App\Models\Guru::where('tipe', 'Kepala Sekolah')
                            ->where('id', '!=', $guruId)
                            ->exists();
                        if ($exists) {
                            $fail('Jabatan Kepala Sekolah sudah ada di sistem dan hanya diperbolehkan satu saja.');
                        }
                    }
                }
            ],
            'foto'                 => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'status'               => ['required', 'in:Aktif,Nonaktif,Cuti'],
            'mata_pelajaran_ids'   => ['required', 'array', 'min:1'],
            'mata_pelajaran_ids.*' => ['exists:mata_pelajaran,id'],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required'              => 'Email wajib diisi.',
            'email.email'                 => 'Format email tidak valid.',
            'email.unique'                => 'Email sudah terdaftar.',
            'password.min'                => 'Password minimal harus 8 karakter.',
            'nip.required'                => 'NIP wajib diisi.',
            'nip.unique'                  => 'NIP sudah terdaftar.',
            'nama_lengkap.required'       => 'Nama lengkap wajib diisi.',
            'jenis_kelamin_id.required'   => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin_id.exists'     => 'Jenis kelamin tidak valid.',
            'agama_id.required'           => 'Agama wajib dipilih.',
            'agama_id.exists'             => 'Agama tidak valid.',
            'tempat_lahir.required'       => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required'      => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'          => 'Format tanggal lahir tidak valid.',
            'telepon.required'            => 'Nomor telepon wajib diisi.',
            'alamat.required'             => 'Alamat wajib diisi.',
            'tipe.required'               => 'Jabatan/Tipe guru wajib dipilih.',
            'tipe.in'                     => 'Jabatan/Tipe guru tidak valid.',
            'foto.image'                  => 'File harus berupa gambar.',
            'foto.mimes'                  => 'Format gambar harus jpeg, png, jpg, webp, atau svg.',
            'foto.max'                    => 'Ukuran gambar maksimal 2MB.',
            'status.required'             => 'Status wajib dipilih.',
            'status.in'                   => 'Status tidak valid.',
            'mata_pelajaran_ids.required' => 'Mata pelajaran wajib dipilih minimal satu.',
            'mata_pelajaran_ids.array'    => 'Format mata pelajaran tidak valid.',
            'mata_pelajaran_ids.*.exists' => 'Mata pelajaran tidak valid.',
        ];
    }
}
