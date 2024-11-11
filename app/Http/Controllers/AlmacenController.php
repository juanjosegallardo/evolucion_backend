<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Almacen::all();
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
    public function store(Request $request)
    {
        $almacen =new Almacen();
        $almacen->nombre = $request->nombre;
        $almacen->save;
    }

    /**
     * Display the specified resource.
     */
    public function show(Almacen $almacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Almacen $almacen)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $almacen = Almacen::findOrFail($id);
        $almacen->nombre=$request->nombre;
        $almacen->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->delete();
    }
}
