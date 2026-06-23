<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'logo_sekolah',
                'value' => 'assets/images/logo_sekolah.png',
            ],
            [
                'key' => 'nama_sekolah',
                'value' => 'SMA Negeri 1 Jakarta',
            ],
            [
                'key' => 'hero_foto',
                'value' => 'assets/images/hero_foto.jpg',
            ],
            [
                'key' => 'foto_kepala_sekolah',
                'value' => 'assets/images/foto_kepala_sekolah.jpg',
            ],
            [
                'key' => 'nama_kepala_sekolah',
                'value' => 'Drs. H. Mulyanto, M.Pd.',
            ],
            [
                'key' => 'sambutan_kepala_sekolah',
                'value' => 'Selamat datang di website resmi sekolah kami. Kami berkomitmen untuk memberikan pendidikan terbaik bagi putra-putri Anda.',
            ],
            [
                'key' => 'sejarah',
                'value' => 'Sekolah ini didirikan pada tahun 1960 dengan visi mencetak generasi unggul yang berkarakter.',
            ],
            [
                'key' => 'visi',
                'value' => 'Terwujudnya generasi yang bertaqwa, cerdas, terampil, berkarakter, dan berwawasan lingkungan.',
            ],
            [
                'key' => 'misi',
                'value' => "1. Menumbuhkan penghayatan dan pengamalan ajaran agama.\n2. Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.\n3. Mengembangkan potensi diri siswa secara optimal.",
            ],
            [
                'key' => 'struktur_organisasi',
                'value' => 'assets/images/struktur_organisasi.jpg',
            ],
            [
                'key' => 'akreditasi',
                'value' => 'A',
            ],
            [
                'key' => 'total_guru',
                'value' => '40+',
            ],
            [
                'key' => 'total_alumni',
                'value' => '1000+',
            ],
            [
                'key' => 'foto_sertifikat_akreditasi',
                'value' => 'assets/images/foto_sertifikat_akreditasi.jpg',
            ],
            [
                'key' => 'nomor_telepon_kantor',
                'value' => '021-123456',
            ],
            [
                'key' => 'nomor_telepon_whatsapp',
                'value' => '081234567890',
            ],
            [
                'key' => 'email',
                'value' => 'info@sman1jakarta.sch.id',
            ],
            [
                'key' => 'alamat_sekolah',
                'value' => 'Jl. Pendidikan No. 123, Weetabula, Sumba Barat Daya, NTT',
            ],
            [
                'key' => 'link_facebook',
                'value' => 'https://facebook.com/sman1jakarta',
            ],
            [
                'key' => 'link_instagram',
                'value' => 'https://instagram.com/sman1jakarta',
            ],
            [
                'key' => 'link_youtube',
                'value' => 'https://youtube.com/sman1jakarta',
            ],
            [
                'key' => 'link_email',
                'value' => 'mailto:info@sman1jakarta.sch.id',
            ],
        ];

        foreach ($settings as $setting) {
            AppSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
