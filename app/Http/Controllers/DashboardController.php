<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\RuanganKelas;
use App\Models\Rombel;
use App\Models\JadwalPelajaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
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

    private function getDataDashboardForAdmin ()
    {
        $userLogin = auth()->user();

        // Get total counts
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalMapel = MataPelajaran::count();
        $totalRombel = Rombel::count();
        $totalRuangan = RuanganKelas::count();
        $totalJadwal = JadwalPelajaran::count();

        // Group by Gender for Donut Chart
        $genderData = Siswa::join('jenis_kelamin', 'siswa.jenis_kelamin_id', '=', 'jenis_kelamin.id')
            ->select('jenis_kelamin.nama as name', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin.nama')
            ->get();

        // Group by Religion for Bar Chart
        $agamaData = Siswa::join('agama', 'siswa.agama_id', '=', 'agama.id')
            ->select('agama.nama as name', DB::raw('count(*) as total'))
            ->groupBy('agama.nama')
            ->get();

        // Group by Status for Pie/Polar Chart
        $statusData = Siswa::select('status as name', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

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

    private function getDataDashboardForGuru ()
    {
        $userLogin = auth()->user();

        return [
            'user'  => $userLogin
        ];
    }

    private function getDataDashboardForKepalaSekolah ()
    {
        $userLogin = auth()->user();

        return [
            'user'  => $userLogin
        ];
    }

    private function getDataDashboardForSiswa ()
    {
        $userLogin = auth()->user();

        return [
            'user'  => $userLogin
        ];
    }
}
