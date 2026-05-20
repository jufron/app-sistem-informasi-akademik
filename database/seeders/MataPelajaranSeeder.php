<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = collect([
            [
                'nama' => 'Pendidikan Agama dan Budi Pekerti',
                'deskripsi' => 'Pendidikan mengenai ajaran keagamaan, nilai-nilai moral, kebaikan, dan perilaku mulia sesuai dengan keyakinan masing-masing peserta didik.',
            ],
            [
                'nama' => 'Pendidikan Pancasila',
                'deskripsi' => 'Menanamkan nilai-nilai luhur Pancasila, pemahaman tentang konstitusi, hak dan kewajiban warga negara, serta rasa cinta tanah air (Nasionalisme).',
            ],
            [
                'nama' => 'Bahasa Indonesia',
                'deskripsi' => 'Pembelajaran keterampilan berbahasa yang meliputi aspek mendengarkan, berbicara, membaca, dan menulis secara baik, benar, dan komunikatif.',
            ],
            [
                'nama' => 'Matematika',
                'deskripsi' => 'Mata pelajaran yang melatih logika, konsep bilangan, operasi hitung dasar (penjumlahan, pengurangan, perkalian, pembagian), geometri, dan pengukuran.',
            ],
            [
                'nama' => 'Ilmu Pengetahuan Alam dan Sosial (IPAS)',
                'deskripsi' => 'Pembelajaran terpadu sains alam dan sosial untuk melatih siswa memahami fenomena alam, sejarah perkembangan sosial, serta interaksi makhluk hidup dengan lingkungannya.',
            ],
            [
                'nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)',
                'deskripsi' => 'Aktivitas fisik yang berfokus pada kebugaran jasmani, koordinasi motorik kasar, disiplin diri, sportivitas, serta pemahaman pola hidup bersih dan sehat.',
            ],
            [
                'nama' => 'Seni Musik',
                'deskripsi' => 'Pembelajaran seni suara, apresiasi lagu nasional/daerah, kepekaan terhadap nada dan ritme, serta pengenalan alat musik sederhana.',
            ],
            [
                'nama' => 'Seni Rupa',
                'deskripsi' => 'Pembelajaran seni visual, menggambar, mewarnai, membuat prakarya/kerajinan tangan, dan mengenal apresiasi karya seni rupa.',
            ],
            [
                'nama' => 'Bahasa Inggris',
                'deskripsi' => 'Pembelajaran dasar bahasa asing yang dirancang untuk mengenalkan kosakata baru, percakapan sehari-hari yang sederhana, serta penulisan dasar.',
            ],
            [
                'nama' => 'Bahasa Daerah (Muatan Lokal)',
                'deskripsi' => 'Pembelajaran bahasa dan sastra daerah setempat guna melestarikan warisan budaya lokal, nilai kesantunan, dan kearifan lokal.',
            ],
        ]);

        $subjects->each(function ($subject) {
            MataPelajaran::create($subject);
        });
    }
}
