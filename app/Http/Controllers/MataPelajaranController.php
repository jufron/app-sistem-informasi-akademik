<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\Models\MataPelajaran;
use Illuminate\Http\RedirectResponse;
use App\DataTables\MataPelajaranDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MataPelajaranDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.mata-pelajaran.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('dashboard.admin.mata-pelajaran.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMataPelajaranRequest $request) : RedirectResponse
    {
        MataPelajaran::create($request->validated());
        flash()->success('Data berhasil ditambahkan!');
        return redirect()->route('dashboard.mata-pelajaran.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MataPelajaran $mataPelajaran) : JsonResponse
    {
        return response()->json($mataPelajaran);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataPelajaran $mataPelajaran) : View
    {
        return view('dashboard.admin.mata-pelajaran.ubah', compact('mataPelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMataPelajaranRequest $request, MataPelajaran $mataPelajaran) : RedirectResponse
    {
        $mataPelajaran->update($request->validated());
        flash()->success('Data berhasil diperbarui!');
        return redirect()->route('dashboard.mata-pelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataPelajaran $mataPelajaran) : RedirectResponse
    {
        $mataPelajaran->delete();
        flash()->success('Data berhasil dihapus!');
        return redirect()->route('dashboard.mata-pelajaran.index');
    }

    /**
     * Remove the specified resources from storage in bulk.
     */
    public function bulkDestroy(\Illuminate\Http\Request $request) : RedirectResponse
    {
        $ids = $request->input('ids');
        if (is_array($ids) && count($ids) > 0) {
            MataPelajaran::whereIn('id', $ids)->delete();
            flash()->success('Berhasil Menghapus Data Terpi lih');
        } else {
            flash()->error('Pilih data terlebih dahulu');
        }
        return redirect()->route('dashboard.mata-pelajaran.index');
    }
}
