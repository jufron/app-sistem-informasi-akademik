<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveNilaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Handled by role/auth middleware, but keep true here
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grades'                       => ['required', 'array'],
            'grades.*.siswa_id'            => ['required', 'exists:siswa,id'],
            'grades.*.nilai_formatif'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'grades.*.nilai_sumatif_materi'=> ['nullable', 'numeric', 'min:0', 'max:100'],
            'grades.*.nilai_sumatif_akhir' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'grades.*.keterangan'          => ['nullable', 'string', 'max:65535'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'grades.*.nilai_formatif'      => 'Nilai Formatif',
            'grades.*.nilai_sumatif_materi'=> 'Nilai Sumatif Lingkup Materi',
            'grades.*.nilai_sumatif_akhir' => 'Nilai Sumatif Akhir Semester',
            'grades.*.keterangan'          => 'Deskripsi Capaian Kompetensi',
        ];
    }
}
