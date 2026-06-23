<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\RevisiPenilaian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KepalaSekolahPenilaianController extends Controller
{
    /**
     * Store a new revision message from the principal.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeRevisi(Request $request): RedirectResponse
    {
        $request->validate([
            'ruangan_kelas_id'  => ['required', 'exists:ruangan_kelas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'pesan'             => ['required', 'string', 'max:65535'],
        ]);

        RevisiPenilaian::create([
            'ruangan_kelas_id'  => $request->input('ruangan_kelas_id'),
            'mata_pelajaran_id' => $request->input('mata_pelajaran_id'),
            'pesan'             => $request->input('pesan'),
            'status'            => 'Pending',
        ]);

        flash()->success('Pesan revisi penilaian berhasil dikirim ke guru.');

        return redirect()->back();
    }
}
