<?php

namespace App\Http\Controllers;

use App\Models\Traspaso;
use App\Http\Requests\StoreTraspasoRequest;
use App\Http\Requests\UpdateTraspasoRequest;

class TraspasoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Traspaso::all();

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
    public function store(StoreTraspasoRequest $request)
    {
        $traspaso = new Traspaso();
        $traspaso->almacen_origen_id = $request->almacen_origen_id;
        $traspaso->almacen_destino_id = $request->almacen_destino_id;
        $traspaso->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Traspaso $traspaso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Traspaso $traspaso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTraspasoRequest $request, Traspaso $traspaso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Traspaso $traspaso)
    {
        //
    }
}
