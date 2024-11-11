<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Http\Requests\StoreArticuloRequest;
use App\Http\Requests\UpdateArticuloRequest;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Articulo::with("tipoArticulo")->get();
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
    public function store(Request $request, $id)
    {
        $articulo = new Articulo();
        $articulo->codigo = $request->codigo;
        $articulo->tipo_articulo_id=$id;
        $articulo->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Articulo $articulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Articulo $articulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Articulo $articulo)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->delete();
    }
}
