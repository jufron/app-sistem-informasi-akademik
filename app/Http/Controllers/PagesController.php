<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function index () : View
    {
        return view('frond.home');
    }

    public function tentang () : View
    {
        return view('frond.tentang');
    }

    public function guruDanPengajar () : View
    {
        return view('frond.guruDanPengajar');
    }

    public function kontak () : View
    {
        return view('frond.kontak');
    }

    public function detailGuruDanStaf () : View
    {
        return view('frond.detailGuruDanStaf');  
    }
}
