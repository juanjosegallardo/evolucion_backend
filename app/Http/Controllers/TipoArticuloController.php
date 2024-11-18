<?php

namespace App\Http\Controllers;

use App\Models\TipoArticulo;
use App\Http\Requests\StoreTipoArticuloRequest;
use App\Http\Requests\UpdateTipoArticuloRequest;

class TipoArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TipoArticulo::all();
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
    public function store(StoreTipoArticuloRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoArticulo $tipoArticulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoArticulo $tipoArticulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoArticuloRequest $request, TipoArticulo $tipoArticulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoArticulo $tipoArticulo)
    {
        //
    }
}
