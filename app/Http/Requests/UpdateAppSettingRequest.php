<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppSettingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'nama_kepala_sekolah' => ['required', 'string', 'max:255'],
            'sambutan_kepala_sekolah' => ['required', 'string'],
            'sejarah' => ['required', 'string'],
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
            'akreditasi' => ['required', 'string', 'max:20'],
            'nomor_telepon_kantor' => ['required', 'string', 'max:50'],
            'nomor_telepon_whatsapp' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'alamat_sekolah' => ['required', 'string'],
            'link_facebook' => ['nullable', 'url', 'max:255'],
            'link_instagram' => ['nullable', 'url', 'max:255'],
            'link_youtube' => ['nullable', 'url', 'max:255'],
            'link_email' => ['nullable', 'string', 'max:255'],
            
            // Files/Images
            'logo_sekolah' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,ico', 'max:2048'],
            'hero_foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:4096'],
            'foto_kepala_sekolah' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'struktur_organisasi' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:4096'],
            'foto_sertifikat_akreditasi' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:4096'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'nama_kepala_sekolah.required' => 'Nama kepala sekolah wajib diisi.',
            'sambutan_kepala_sekolah.required' => 'Sambutan kepala sekolah wajib diisi.',
            'sejarah.required' => 'Sejarah sekolah wajib diisi.',
            'visi.required' => 'Visi sekolah wajib diisi.',
            'misi.required' => 'Misi sekolah wajib diisi.',
            'akreditasi.required' => 'Akreditasi wajib diisi.',
            'nomor_telepon_kantor.required' => 'Nomor telepon kantor wajib diisi.',
            'nomor_telepon_whatsapp.required' => 'Nomor telepon WhatsApp wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'alamat_sekolah.required' => 'Alamat sekolah wajib diisi.',
            'link_facebook.url' => 'Format URL Facebook tidak valid.',
            'link_instagram.url' => 'Format URL Instagram tidak valid.',
            'link_youtube.url' => 'Format URL YouTube tidak valid.',
            
            // Image validations
            'logo_sekolah.image' => 'Logo sekolah harus berupa gambar.',
            'logo_sekolah.max' => 'Logo sekolah tidak boleh lebih dari 2MB.',
            'hero_foto.image' => 'Hero foto harus berupa gambar.',
            'hero_foto.max' => 'Hero foto tidak boleh lebih dari 4MB.',
            'foto_kepala_sekolah.image' => 'Foto kepala sekolah harus berupa gambar.',
            'foto_kepala_sekolah.max' => 'Foto kepala sekolah tidak boleh lebih dari 2MB.',
            'struktur_organisasi.image' => 'Struktur organisasi harus berupa gambar.',
            'struktur_organisasi.max' => 'Struktur organisasi tidak boleh lebih dari 4MB.',
            'foto_sertifikat_akreditasi.image' => 'Foto sertifikat akreditasi harus berupa gambar.',
            'foto_sertifikat_akreditasi.max' => 'Foto sertifikat akreditasi tidak boleh lebih dari 4MB.',
        ];
    }
}
