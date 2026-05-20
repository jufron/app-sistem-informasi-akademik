<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\Models\MataPelajaran;
use Illuminate\Http\RedirectResponse;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMataPelajaranRequest $request) : RedirectResponse
    {
        MataPelajaran::create($request->validated());
        notify()->success()->title('Berhasil Menambahkan Data')->send();
        return redirect()->route('dashboard.mata-pelajaran.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MataPelajaran $mataPelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataPelajaran $mataPelajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMataPelajaranRequest $request, MataPelajaran $mataPelajaran) : RedirectResponse
    {
        $mataPelajaran->update($request->validated());
        notify()->success()->title('Berhasil Memperbaru Data')->send();
        return redirect()->route('dashboard.mata-pelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataPelajaran $mataPelajaran) : RedirectResponse
    {
        $mataPelajaran->delete();
        notify()->success()->title('Berhasil Menghapus Data')->send();
        return redirect()->route('dashboard.mata-pelajaran.index');
    }
}
