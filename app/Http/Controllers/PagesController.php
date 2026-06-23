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
        return view('frond.tentang');
    }

    /**
     * Display the list of teachers and staff page.
     *
     * @return View
     */
    public function guruDanPengajar () : View
    {
        return view('frond.guruDanPengajar');
    }

    /**
     * Display the contact form / details page.
     *
     * @return View
     */
    public function kontak () : View
    {
        return view('frond.kontak');
    }

    /**
     * Display detailed profile information for a specific teacher/staff member.
     *
     * @return View
     */
    public function detailGuruDanStaf () : View
    {
        return view('frond.detailGuruDanStaf');  
    }
}
