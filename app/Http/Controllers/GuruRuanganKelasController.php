<?php

namespace App\Http\Controllers;

use App\DataTables\GuruRuanganKelasDataTable;
use App\Repositories\Interfaces\KelasRepositoryInterface;
use App\Repositories\Interfaces\RombelRepositoryInterface;
use App\Repositories\Interfaces\SemesterRepositoryInterface;
use App\Repositories\Interfaces\RuanganKelasRepositoryInterface;
use App\Repositories\Interfaces\SiswaRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuruRuanganKelasController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected KelasRepositoryInterface $kelasRepo,
        protected RombelRepositoryInterface $rombelRepo,
        protected SemesterRepositoryInterface $semesterRepo,
        protected RuanganKelasRepositoryInterface $ruanganKelasRepo,
        protected SiswaRepositoryInterface $siswaRepo
    ) {}

    /**
     * Display a listing of classrooms.
     */
    public function index(GuruRuanganKelasDataTable $dataTable)
    {
        $kelas = $this->kelasRepo->getAll();
        $rombel = $this->rombelRepo->getAll();
        $semester = $this->semesterRepo->getAll();

        return $dataTable->render('dashboard.guru.ruangan-kelas.index', compact('kelas', 'rombel', 'semester'));
    }

    /**
     * Display the specified classroom and its students.
     */
    public function show($id): View
    {
        $ruanganKelas = $this->ruanganKelasRepo->findById($id);
        
        if (!$ruanganKelas) {
            abort(404);
        }

        $ruanganKelas->load(['kelas', 'rombel', 'semester', 'guru', 'anggotaKelas.siswa.jenisKelamin']);
        
        return view('dashboard.guru.ruangan-kelas.show', compact('ruanganKelas'));
    }

    /**
     * Display the student profile.
     */
    public function showSiswa($id): View
    {
        $siswa = $this->siswaRepo->findById($id);

        if (!$siswa) {
            abort(404);
        }

        $siswa->load(['jenisKelamin', 'agama']);
        
        return view('dashboard.guru.siswa.show', compact('siswa'));
    }
}
