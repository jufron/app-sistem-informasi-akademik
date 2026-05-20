<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard ()
    {
        $userLogin = auth()->user();
        
        if ($userLogin->hasRole('admin')) {
            notify()->success()->title('Selamat Datang Admin')->send();
            return view('dashboard.admin.dashboard', $this->getDataDashboardForAdmin());
        } else if ($userLogin->hasRole('guru')) {
            notify()->success()->title('Selamat Datang Guru')->send();
            return view('dashboard.guru.dashboard', $this->getDataDashboardForGuru());
        } else if ($userLogin->hasRole('kepala-sekolah')) {
            notify()->success()->title('Selamat Datang Kepala Sekolah')->send();
            return view('dashboard.kepala-sekolah.dashboard', $this->getDataDashboardForKepalaSekolah());
        } else if ($userLogin->hasRole('siswa')) {
            notify()->success()->title('Selamat Datang Siswa')->send();
            return view('dashboard.siswa.dashboard', $this->getDataDaDashboardForSiswa());
        } else {
            return view('dashboard');
        }
    }

    private function getDataDashboardForAdmin ()
    {
        $userLogin = auth()->user();

        return [
            'user'  => $userLogin
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

    private function getDataDaDashboardForSiswa ()
    {
        $userLogin = auth()->user();

        return [
            'user'  => $userLogin
        ];
    }
}
