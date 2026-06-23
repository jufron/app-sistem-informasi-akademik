<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\SiswaRepositoryInterface;
use App\Repositories\Interfaces\GuruRepositoryInterface;
use App\Repositories\Interfaces\MataPelajaranRepositoryInterface;
use App\Repositories\Interfaces\RombelRepositoryInterface;
use App\Repositories\Interfaces\RuanganKelasRepositoryInterface;
use App\Repositories\Interfaces\JadwalPelajaranRepositoryInterface;
use App\Repositories\Interfaces\AnggotaKelasRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * 
 * Handles dashboard data routing and rendering for all active roles (Admin, Guru, Kepala Sekolah, Siswa).
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * Injects the required repository services using PHP 8 constructor property promotion.
     *
     * @param SiswaRepositoryInterface $siswaRepo
     * @param GuruRepositoryInterface $guruRepo
     * @param MataPelajaranRepositoryInterface $mapelRepo
     * @param RombelRepositoryInterface $rombelRepo
     * @param RuanganKelasRepositoryInterface $ruanganRepo
     * @param JadwalPelajaranRepositoryInterface $jadwalRepo
     * @param AnggotaKelasRepositoryInterface $anggotaRepo
     */
    public function __construct(
        protected SiswaRepositoryInterface $siswaRepo,
        protected GuruRepositoryInterface $guruRepo,
        protected MataPelajaranRepositoryInterface $mapelRepo,
        protected RombelRepositoryInterface $rombelRepo,
        protected RuanganKelasRepositoryInterface $ruanganRepo,
        protected JadwalPelajaranRepositoryInterface $jadwalRepo,
        protected AnggotaKelasRepositoryInterface $anggotaRepo
    ) {}

    /**
     * Determine user role and load their respective dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard ()
    {
        $userLogin = auth()->user();
        
        if ($userLogin->hasRole('admin')) {
            flash()->success('Selamat Datang Admin');
            return view('dashboard.admin.dashboard', $this->getDataDashboardForAdmin());
        } else if ($userLogin->hasRole('guru')) {
            flash()->success('Selamat Datang Guru');
            return view('dashboard.guru.dashboard', $this->getDataDashboardForGuru());
        } else if ($userLogin->hasRole('kepala-sekolah')) {
            flash()->success('Selamat Datang Kepala Sekolah');
            return view('dashboard.kepala-sekolah.dashboard', $this->getDataDashboardForKepalaSekolah());
        } else if ($userLogin->hasRole('siswa')) {
            flash()->success('Selamat Datang Siswa');
            return view('dashboard.siswa.dashboard', $this->getDataDashboardForSiswa());
        } else {
            return view('dashboard');
        }
    }

    /**
     * Compile statistical counter and demographic distribution data for the Admin dashboard.
     *
     * @return array
     */
    private function getDataDashboardForAdmin ()
    {
        $userLogin = auth()->user();

        // Get total counts
        $totalSiswa = $this->siswaRepo->count();
        $totalGuru = $this->guruRepo->count();
        $totalMapel = $this->mapelRepo->count();
        $totalRombel = $this->rombelRepo->count();
        $totalRuangan = $this->ruanganRepo->count();
        $totalJadwal = $this->jadwalRepo->count();

        // Group by Gender for Donut Chart
        $genderData = $this->siswaRepo->getGenderDistribution();

        // Group by Religion for Bar Chart
        $agamaData = $this->siswaRepo->getReligionDistribution();

        // Group by Status for Pie/Polar Chart
        $statusData = $this->siswaRepo->getStatusDistribution();

        return [
            'user'          => $userLogin,
            'totalSiswa'    => $totalSiswa,
            'totalGuru'     => $totalGuru,
            'totalMapel'    => $totalMapel,
            'totalRombel'   => $totalRombel,
            'totalRuangan'  => $totalRuangan,
            'totalJadwal'   => $totalJadwal,
            'genderData'    => $genderData,
            'agamaData'     => $agamaData,
            'statusData'    => $statusData,
        ];
    }

    /**
     * Compile homeroom classroom, classroom roster list, and schedule data for the Teacher (Guru) dashboard.
     *
     * @return array
     */
    private function getDataDashboardForGuru ()
    {
        $userLogin = auth()->user();
        $guru = $userLogin->guru;
        
        $ruanganWali = null;
        $anggotaSiswa = collect();
        $jadwalPelajaran = collect();
        $mataPelajaran = collect();
        $totalSiswaWali = 0;
        $totalMapelAjar = 0;
        $revisionsPending = collect();
        
        if ($guru) {
            $ruanganWali = $this->ruanganRepo->findByGuruId($guru->id);
            if ($ruanganWali) {
                $anggotaSiswa = $this->anggotaRepo->getByRuanganKelasId($ruanganWali->id);
                $totalSiswaWali = $anggotaSiswa->count();
            }
            $totalMapelAjar = $guru->mataPelajaran()->count();
            $mataPelajaran = $guru->mataPelajaran;
            $jadwalPelajaran = $this->jadwalRepo->getByGuruId($guru->id);

            // Fetch pending revisions for the classrooms and subjects where this teacher teaches
            $revisionsPending = \App\Models\RevisiPenilaian::with(['ruanganKelas.kelas', 'ruanganKelas.rombel', 'mataPelajaran'])
                ->where('status', 'Pending')
                ->whereExists(function ($query) use ($guru) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('ruangan_kelas')
                        ->join('jadwal_pelajaran', function ($join) {
                            $join->on('jadwal_pelajaran.kelas_id', '=', 'ruangan_kelas.kelas_id')
                                 ->on('jadwal_pelajaran.rombel_id', '=', 'ruangan_kelas.rombel_id')
                                 ->on('jadwal_pelajaran.semester_id', '=', 'ruangan_kelas.semester_id');
                        })
                        ->whereColumn('ruangan_kelas.id', '=', 'revisi_penilaian.ruangan_kelas_id')
                        ->whereColumn('jadwal_pelajaran.mata_pelajaran_id', '=', 'revisi_penilaian.mata_pelajaran_id')
                        ->where('jadwal_pelajaran.guru_id', $guru->id);
                })
                ->latest()
                ->get();
        }

        return [
            'user'             => $userLogin,
            'guru'             => $guru,
            'ruanganWali'      => $ruanganWali,
            'anggotaSiswa'     => $anggotaSiswa,
            'totalSiswaWali'   => $totalSiswaWali,
            'totalMapelAjar'   => $totalMapelAjar,
            'mataPelajaran'    => $mataPelajaran,
            'jadwalPelajaran'  => $jadwalPelajaran,
            'revisionsPending' => $revisionsPending,
        ];
    }

    /**
     * Compile statistical counter and gender/status distributions for the Kepala Sekolah dashboard.
     *
     * @return array
     */
    private function getDataDashboardForKepalaSekolah ()
    {
        $userLogin = auth()->user();
        
        $totalSiswa = $this->siswaRepo->count();
        $totalGuru = $this->guruRepo->count();
        $totalMapel = $this->mapelRepo->count();
        $totalRombel = $this->rombelRepo->count();
        $totalRuangan = $this->ruanganRepo->count();
        $totalJadwal = $this->jadwalRepo->count();

        // Group by Gender for Donut Chart
        $genderData = $this->siswaRepo->getGenderDistribution();

        // Group by Status for Area Chart
        $statusData = $this->siswaRepo->getStatusDistribution();

        // Retrieve classrooms for select dropdown
        $classrooms = \App\Models\RuanganKelas::with(['kelas', 'rombel', 'semester'])->get();

        $selectedClassroomId = request('ruangan_kelas_id') !== null ? (int)request('ruangan_kelas_id') : null;
        $selectedSubjectId = request('mata_pelajaran_id') !== null ? (int)request('mata_pelajaran_id') : null;
        
        $subjects = collect();
        $gradesSheet = [];
        $revisions = collect();

        if ($selectedClassroomId) {
            $classroom = \App\Models\RuanganKelas::find($selectedClassroomId);
            if ($classroom) {
                // Get all subjects taught in this classroom via JadwalPelajaran
                $subjects = \App\Models\MataPelajaran::whereHas('jadwalPelajaran', function ($query) use ($classroom) {
                    $query->where('kelas_id', $classroom->kelas_id)
                        ->where('rombel_id', $classroom->rombel_id)
                        ->where('semester_id', $classroom->semester_id);
                })->get();

                if ($selectedSubjectId && $subjects->pluck('id')->contains($selectedSubjectId)) {
                    $students = \App\Models\Siswa::whereHas('anggotaKelas', function ($q) use ($selectedClassroomId) {
                        $q->where('ruangan_kelas_id', $selectedClassroomId)
                          ->where('status', 'Aktif');
                    })
                    ->orderBy('nama_lengkap', 'asc')
                    ->get();

                    $nilaiRepo = app(\App\Repositories\Interfaces\NilaiRepositoryInterface::class);
                    $grades = $nilaiRepo->getGrades($selectedClassroomId, $selectedSubjectId)->keyBy('siswa_id');

                    foreach ($students as $student) {
                        $gradesSheet[] = [
                            'siswa' => $student,
                            'nilai' => $grades->get($student->id),
                        ];
                    }

                    // Get revision requests history
                    $revisions = \App\Models\RevisiPenilaian::where('ruangan_kelas_id', $selectedClassroomId)
                        ->where('mata_pelajaran_id', $selectedSubjectId)
                        ->latest()
                        ->get();
                }
            }
        }

        return [
            'user'                => $userLogin,
            'totalSiswa'          => $totalSiswa,
            'totalGuru'           => $totalGuru,
            'totalMapel'          => $totalMapel,
            'totalRombel'         => $totalRombel,
            'totalRuangan'        => $totalRuangan,
            'totalJadwal'         => $totalJadwal,
            'genderData'          => $genderData,
            'statusData'          => $statusData,
            'classrooms'          => $classrooms,
            'selectedClassroomId' => $selectedClassroomId,
            'selectedSubjectId'   => $selectedSubjectId,
            'subjects'            => $subjects,
            'gradesSheet'         => $gradesSheet,
            'revisions'           => $revisions,
        ];
    }

    /**
     * Compile current classroom details, class schedule, and classmates' rosters for the Student (Siswa) dashboard.
     *
     * @return array
     */
    private function getDataDashboardForSiswa ()
    {
        $userLogin = auth()->user();
        $siswa = $this->siswaRepo->findByUserId($userLogin->id);
        
        $anggotaKelasActive = null;
        $temanSekelas = collect();
        $jadwalPelajaran = collect();
        
        if ($siswa) {
            $anggotaKelasActive = $this->anggotaRepo->findActiveBySiswaId($siswa->id);
                
            if ($anggotaKelasActive && $anggotaKelasActive->ruanganKelas) {
                $ruangan = $anggotaKelasActive->ruanganKelas;
                
                $temanSekelas = $this->anggotaRepo->getClassmates($ruangan->id, $siswa->id);
                    
                $jadwalPelajaran = $this->jadwalRepo->getByClassAndRombel($ruangan->kelas_id, $ruangan->rombel_id);
            }
        }

        return [
            'user'               => $userLogin,
            'siswa'              => $siswa,
            'anggotaKelasActive' => $anggotaKelasActive,
            'temanSekelas'       => $temanSekelas,
            'jadwalPelajaran'    => $jadwalPelajaran,
        ];
    }
}
