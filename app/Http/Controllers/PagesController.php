<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Interfaces\AppSettingRepositoryInterface;
use App\Repositories\Interfaces\GuruRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class PagesController
 * 
 * Manages rendering of public front-end pages (Home, About, Teacher list, Contact, details).
 */
class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * Injects the AppSettingRepositoryInterface and GuruRepositoryInterface using PHP 8.0 constructor property promotion.
     * 
     * @param AppSettingRepositoryInterface $appSettingRepo
     * @param GuruRepositoryInterface $guruRepo
     */
    public function __construct(
        protected AppSettingRepositoryInterface $appSettingRepo,
        protected GuruRepositoryInterface $guruRepo
    ) {}

    /**
     * Display the public landing page (home).
     * Calculates the hero background image URL.
     *
     * @return View
     */
    public function index () : View
    {
        $heroUrl                    = $this->appSettingRepo->getImageUrl('hero_foto', asset('img/photo-1577896851231-70ef18881754 (1).jpg'));
        $kepsekFotoUrl              = $this->appSettingRepo->getImageUrl('foto_kepala_sekolah', asset('img/photo-1560250097-0b93528c311a (1).jpg'));
        $akreditasi                 = $this->appSettingRepo->getValue('akreditasi', 'A');
        $totalGuru                  = $this->appSettingRepo->getValue('total_guru', '40+');
        $totalAlumni                = $this->appSettingRepo->getValue('total_alumni', '1000+');
        
        $sambutanKepalaSekolah      = $this->appSettingRepo->getValue(
            'sambutan_kepala_sekolah',
            "Selamat datang di website resmi SD Katolik Weetabula. Puji syukur kita panjatkan kepada Tuhan Yang Maha Esa atas berkat dan rahmat-Nya, sehingga platform digital ini dapat hadir sebagai jembatan informasi antara pihak sekolah, orang tua, dan masyarakat luas.\n\nKami berkomitmen untuk tidak hanya fokus pada pencapaian akademik, tetapi juga penanaman nilai-nilai moral, kedisiplinan, dan cinta kasih. Mari bersama-sama kita bentuk generasi penerus yang cerdas, beriman, dan siap menghadapi tantangan global."
        );
        $namaKepalaSekolah          = $this->appSettingRepo->getValue('nama_kepala_sekolah', 'Nama Kepala Sekolah, S.Pd.');
        
        $slides                     = $this->guruRepo->getTeachersForHomeSlide();
        
        return view('frond.home', compact(
            'heroUrl',
            'kepsekFotoUrl',
            'akreditasi',
            'totalGuru',
            'totalAlumni',
            'sambutanKepalaSekolah',
            'namaKepalaSekolah',
            'slides'
        ));
    }

    /**
     * Display the 'About' page.
     *
     * @return View
     */
    public function tentang () : View
    {
        $sejarahRaw = $this->appSettingRepo->getValue(
            key: 'sejarah', 
            default: 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Esse nesciunt eaque repudiandae corporis quos? Exercitationem natus a consequatur nisi vero, maxime quisquam totam perspiciatis ad aliquid numquam quaerat alias veniam.'
        );

        $misiRaw = $this->appSettingRepo->getValue(
            key: 'misi', 
            default: "1. Menumbuhkan penghayatan dan pengamalan ajaran agama.\n2. Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.\n3. Mengembangkan potensi diri siswa secara optimal."
        );

        // Process Sejarah drop-cap logic in controller
        $firstLetter = mb_substr($sejarahRaw, 0, 1);
        $restOfSejarah = mb_substr($sejarahRaw, 1);

        // Process Misi lines logic in controller
        $misiLinesRaw = array_filter(array_map('trim', explode("\n", $misiRaw)));
        $misiLines = [];
        foreach ($misiLinesRaw as $line) {
            if (!empty($line)) {
                // Strip numbers/bullets like "1. ", "2. ", "1) " at the start
                $misiLines[] = preg_replace('/^\d+[\.\)]\s*/', '', $line);
            }
        }

        return view('frond.tentang', [
            'firstLetter'           => $firstLetter,
            'restOfSejarah'         => $restOfSejarah,
            'visi'                  => $this->appSettingRepo->getValue(key: 'visi', default: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, a!'),
            'misiLines'             => $misiLines,
            'strukturOrganisasiUrl' => $this->appSettingRepo->getImageUrl(key: 'struktur_organisasi', defaultUrl: asset('img/struktur_organisasi.jpg')),
        ]);
    }

    /**
     * Display the list of teachers and staff page.
     *
     * @return View
     */
    public function guruDanPengajar () : View
    {
        $teachersCollection = $this->guruRepo->getAll();
        $teachersCollection->load(['mataPelajaran', 'jenisKelamin']);

        $staffList = [];
        foreach ($teachersCollection as $guru) {
            $img = null;
            if (!empty($guru->foto)) {
                if (str_starts_with($guru->foto, 'assets/') || str_starts_with($guru->foto, 'img/')) {
                    $img = asset($guru->foto);
                } else {
                    $img = asset('storage/' . $guru->foto);
                }
            }
            if (empty($img)) {
                $imagesMap = [
                    'Antonius Budi' => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=800&h=1000&auto=format&fit=crop',
                    'Maria Yosefina' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&h=1000&auto=format&fit=crop',
                    'Yohanes Don Bosco' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&h=1000&auto=format&fit=crop',
                ];
                foreach ($imagesMap as $nameKey => $imgUrl) {
                    if (stripos($guru->nama_lengkap, $nameKey) !== false) {
                        $img = $imgUrl;
                        break;
                    }
                }
            }
            if (empty($img)) {
                if ($guru->jenisKelamin && $guru->jenisKelamin->kode === 'P') {
                    $img = 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&h=1000&auto=format&fit=crop';
                } else {
                    $img = 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=800&h=1000&auto=format&fit=crop';
                }
            }

            $subject = $guru->mataPelajaran->pluck('nama')->implode(' & ') ?: 'Pengajar';
            $staffList[] = [
                'id'      => $guru->id,
                'name'    => $guru->nama_lengkap,
                'role'    => $guru->tipe ?? 'Guru',
                'subject' => $subject,
                'status'  => $guru->status === 'Aktif' ? 'Guru Tetap' : $guru->status,
                'image'   => $img
            ];
        }

        if (empty($staffList)) {
            $staffList = [
                [ 'id' => 1, 'name' => 'Antonius Budi, S.Pd', 'role' => 'Wali Kelas 6', 'subject' => 'Matematika & IPA', 'status' => 'Guru Tetap', 'image' => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=800&h=1000&auto=format&fit=crop' ],
                [ 'id' => 2, 'name' => 'Maria Yosefina, S.Pd', 'role' => 'Guru Bahasa Inggris', 'subject' => 'Bahasa Asing', 'status' => 'Guru Tetap', 'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&h=1000&auto=format&fit=crop' ],
                [ 'id' => 3, 'name' => 'Yohanes Don Bosco', 'role' => 'Guru Agama', 'subject' => 'Pend. Agama Katolik', 'status' => 'Guru Tetap', 'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&h=1000&auto=format&fit=crop' ],
                [ 'id' => 4, 'name' => 'Fransiska N., S.Kom', 'role' => 'Guru TIK', 'subject' => 'Komputer', 'status' => 'Tenaga Honorer', 'image' => 'https://images.unsplash.com/photo-1531123897727-8f129e1b4eca?q=80&w=800&h=1000&auto=format&fit=crop' ],
                [ 'id' => 5, 'name' => 'Agustinus D.', 'role' => 'Guru Penjaskes', 'subject' => 'Olahraga', 'status' => 'Guru Tetap', 'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=800&h=1000&auto=format&fit=crop' ],
                [ 'id' => 6, 'name' => 'Theresia Lende', 'role' => 'Staf Perpustakaan', 'subject' => 'Administrasi', 'status' => 'Staf', 'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=800&h=1000&auto=format&fit=crop' ]
            ];
        }

        return view('frond.guruDanPengajar', compact('staffList'));
    }

    /**
     * Display the contact form / details page.
     *
     * @return View
     */
    public function kontak () : View
    {
        $kontak = [
            'alamat'   => $this->appSettingRepo->getValue('alamat_sekolah', 'Kota Tambolaka, Weetabula, Kab. Sumba Barat Daya, Nusa Tenggara Timur.'),
            'telepon'  => $this->appSettingRepo->getValue('nomor_telepon_kantor', '+62 21 123456'),
            'whatsapp' => $this->appSettingRepo->getValue('nomor_telepon_whatsapp', '081234567890'),
            'email'    => $this->appSettingRepo->getValue('email', 'info@sdkatolikweetabula.sch.id'),
        ];
        return view('frond.kontak', compact('kontak'));
    }

    /**
     * Display detailed profile information for a specific teacher/staff member.
     *
     * @param int|string $id
     * @return View
     */
    public function detailGuruDanStaf (int|string $id = 1) : View
    {
        $guru = $this->guruRepo->findById($id);

        if ($guru) {
            $guru->load(['mataPelajaran', 'jenisKelamin']);
            
            $img = null;
            if (!empty($guru->foto)) {
                if (str_starts_with($guru->foto, 'assets/') || str_starts_with($guru->foto, 'img/')) {
                    $img = asset($guru->foto);
                } else {
                    $img = asset('storage/' . $guru->foto);
                }
            }
            if (empty($img)) {
                $imagesMap = [
                    'Antonius Budi' => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=800&h=1000&auto=format&fit=crop',
                    'Maria Yosefina' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&h=1000&auto=format&fit=crop',
                    'Yohanes Don Bosco' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&h=1000&auto=format&fit=crop',
                ];
                foreach ($imagesMap as $nameKey => $imgUrl) {
                    if (stripos($guru->nama_lengkap, $nameKey) !== false) {
                        $img = $imgUrl;
                        break;
                    }
                }
            }
            if (empty($img)) {
                if ($guru->jenisKelamin && $guru->jenisKelamin->kode === 'P') {
                    $img = 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&h=1000&auto=format&fit=crop';
                } else {
                    $img = 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=800&h=1000&auto=format&fit=crop';
                }
            }

            $subjects = $guru->mataPelajaran->pluck('nama')->toArray();
            
            $teacherDetail = [
                'name'      => $guru->nama_lengkap,
                'role'      => $guru->tipe ?? 'Guru',
                'status'    => $guru->status === 'Aktif' ? 'Guru Tetap' : $guru->status,
                'image'     => $img,
                'about'     => 'Memiliki pengalaman luar biasa di dunia pendidikan dasar. Berkomitmen untuk tidak hanya mencerdaskan secara intelektual, tetapi juga menumbuhkan karakter mulia dan disiplin tinggi pada anak didik.',
                'education' => 'S1 Kependidikan (Lulus)',
                'subjects'  => $subjects,
                'phone'     => $guru->telepon ?? '-',
                'address'   => $guru->alamat ?? '-'
            ];
        } else {
            $defaults = [
                1 => [ 'name' => 'Antonius Budi, S.Pd', 'role' => 'Wali Kelas 6 & Guru Matematika', 'subjects' => ['Matematika', 'IPA'], 'status' => 'Guru Tetap', 'image' => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=800&h=1000&auto=format&fit=crop', 'about' => 'Memiliki pengalaman lebih dari 10 tahun di dunia pendidikan dasar. Lulusan Universitas Nusa Cendana ini sangat percaya bahwa setiap anak memiliki cara unik dalam memahami angka dan logika.', 'education' => 'S1 Pendidikan Guru Sekolah Dasar (PGSD) - Universitas Nusa Cendana (2014)', 'phone' => '0812-3456-7890', 'address' => 'Weetabula, Sumba Barat Daya' ],
                2 => [ 'name' => 'Maria Yosefina, S.Pd', 'role' => 'Guru Bahasa Inggris', 'subjects' => ['Bahasa Inggris', 'Bahasa Indonesia'], 'status' => 'Guru Tetap', 'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&h=1000&auto=format&fit=crop', 'about' => 'Mengajar bahasa asing dengan metode komunikatif, interaktif, dan penuh keceriaan. Sangat menyukai dunia literasi anak.', 'education' => 'S1 Pendidikan Bahasa Inggris - Universitas Katolik Widya Mandira (2016)', 'phone' => '0812-3456-7891', 'address' => 'Weetabula, Sumba Barat Daya' ],
                3 => [ 'name' => 'Yohanes Don Bosco', 'role' => 'Guru Agama', 'subjects' => ['Pendidikan Agama Katolik'], 'status' => 'Guru Tetap', 'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&h=1000&auto=format&fit=crop', 'about' => 'Membina rohani dan nilai budi pekerti luhur bagi generasi masa depan sekolah.', 'education' => 'S1 Filsafat dan Teologi - Sekolah Tinggi Filsafat Teologi (2012)', 'phone' => '0812-3456-7892', 'address' => 'Weetabula, Sumba Barat Daya' ],
                4 => [ 'name' => 'Fransiska N., S.Kom', 'role' => 'Guru TIK', 'subjects' => ['Komputer'], 'status' => 'Tenaga Honorer', 'image' => 'https://images.unsplash.com/photo-1531123897727-8f129e1b4eca?q=80&w=800&h=1000&auto=format&fit=crop', 'about' => 'Membimbing siswa mengenal dunia digital secara bijak, kreatif, dan inovatif.', 'education' => 'S1 Sistem Informasi - STIKOM Uyelindo Kupang (2018)', 'phone' => '0812-3456-7893', 'address' => 'Weetabula, Sumba Barat Daya' ],
                5 => [ 'name' => 'Agustinus D.', 'role' => 'Guru Penjaskes', 'subjects' => ['Olahraga'], 'status' => 'Guru Tetap', 'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=800&h=1000&auto=format&fit=crop', 'about' => 'Membentuk jasmani yang bugar dan menanamkan jiwa sportivitas serta disiplin tinggi melalui olahraga.', 'education' => 'S1 Pendidikan Olahraga & Kesehatan - Universitas Negeri Makassar (2015)', 'phone' => '0812-3456-7894', 'address' => 'Weetabula, Sumba Barat Daya' ],
                6 => [ 'name' => 'Theresia Lende', 'role' => 'Staf Perpustakaan', 'subjects' => ['Administrasi'], 'status' => 'Staf', 'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=800&h=1000&auto=format&fit=crop', 'about' => 'Mengelola administrasi perpustakaan sekolah serta membina minat baca siswa sejak dini.', 'education' => 'D3 Perpustakaan & Kearsipan (2017)', 'phone' => '0812-3456-7895', 'address' => 'Weetabula, Sumba Barat Daya' ]
            ];

            $teacherDetail = $defaults[$id] ?? $defaults[1];
        }

        return view('frond.detailGuruDanStaf', compact('teacherDetail'));
    }
}
