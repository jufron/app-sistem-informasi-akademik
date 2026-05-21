<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
