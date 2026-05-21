<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMataPelajaranRequest extends FormRequest
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
        $mataPelajaran = $this->route('mataPelajaran') ?: $this->route('mata_pelajaran');
        $id = is_object($mataPelajaran) ? $mataPelajaran->id : $mataPelajaran;

        return [
            'nama'          => ['required', 'string', 'max:100', 'unique:mata_pelajaran,nama,' . $id],
            'deskripsi'     => ['nullable', 'string', 'max:16383'],
        ];
    }
}
