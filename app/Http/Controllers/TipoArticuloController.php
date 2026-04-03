<?php

namespace App\Http\Controllers;

use App\Models\TipoArticulo;
use App\Http\Requests\StoreTipoArticuloRequest;
use App\Http\Requests\UpdateTipoArticuloRequest;
use App\Services\TipoArticuloService;
use Illuminate\Http\Request;

class TipoArticuloController extends Controller
{

    public function __construct(TipoArticuloService $service)
    {
        $this->service = $service;
    }   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TipoArticulo::orderBy("nombre", "asc")->get();
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
     
        return $this->service->guardar($request->validated());
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
    public function edit(EditTipoArticuloRequest $request, TipoArticulo $tipoArticulo)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoArticuloRequest $request, $id)
    {
     
        return $this->service->actualizar($request->validated(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoArticulo $tipoArticulo)
    {
        //
    }
}
