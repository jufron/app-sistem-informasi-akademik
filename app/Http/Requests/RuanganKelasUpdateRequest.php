<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RuanganKelasUpdateRequest extends FormRequest
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
            'kelas_id'       => ['required', 'exists:kelas,id'],
            'rombel_id'      => ['required', 'exists:rombel,id'],
            'semester_id'    => ['required', 'exists:semester,id'],
            'guru_id'        => ['required', 'exists:guru,id'],
            'tahun_angkatan' => ['required', 'string', 'max:4'],
            'tahun_ajaran'   => ['required', 'string', 'max:50'],
            'aktif'          => ['sometimes', 'boolean'],
            'siswa_ids'        => ['nullable', 'array'],
            'siswa_ids.*'      => ['nullable', 'exists:siswa,id'],
            'tanggal_masuks'   => ['nullable', 'array'],
            'tanggal_masuks.*' => ['required_with:siswa_ids.*', 'nullable', 'date'],
            'tanggal_keluars'  => ['nullable', 'array'],
            'tanggal_keluars.*'=> ['nullable', 'date'],
            'statuses'         => ['nullable', 'array'],
            'statuses.*'       => ['required_with:siswa_ids.*', 'nullable', 'in:Aktif,Naik Kelas,Tinggal Kelas,Mutasi Keluar,Mutasi Masuk,Lulus,Keluar'],
            'keterangans'      => ['nullable', 'array'],
            'keterangans.*'    => ['nullable', 'string', 'max:255'],
        ];
    }
}
