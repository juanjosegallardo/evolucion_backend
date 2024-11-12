<?php

namespace App\Http\Controllers;

use App\Models\Traspaso;
use App\Http\Requests\StoreTraspasoRequest;
use App\Http\Requests\UpdateTraspasoRequest;
use Illuminate\Http\Request;


class TraspasoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Traspaso::with("origen")->with("destino")->with("articulos")->orderBy("created_at", "desc")->get();
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
        $traspaso = new Traspaso();
        $traspaso->almacen_origen_id = $request->almacen_origen_id;
        $traspaso->almacen_destino_id = $request->almacen_destino_id;
        $traspaso->save();
        return Traspaso::with("origen")->with("destino")->find($traspaso->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->with("origen")->with("destino")->find($id);
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
