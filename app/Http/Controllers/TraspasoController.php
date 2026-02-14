<?php

namespace App\Http\Controllers;

use App\Models\Traspaso;
use App\Http\Requests\StoreTraspasoRequest;
use App\Http\Requests\UpdateTraspasoRequest;
use Illuminate\Http\Request;
use App\Services\TraspasoService;
use Illuminate\Support\Facades\DB;


class TraspasoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(TraspasoService $traspasoService)
    {
        $this->traspasoService = $traspasoService;
    }


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
        $traspaso->notas = $request->notas;
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
    public function destroy($id)
    {
        $traspaso = Traspaso::find($id);
        $traspaso->delete();
    }

    
    public function solicitarValidacion($id)
    {
        $this->traspasoService->solicitar($id);
        return Traspaso::with("origen")->with("destino")->find($id);
    }   

    public function validar($id)
    {
        $this->traspasoService->validar($id);
        return Traspaso::with("origen")->with("destino")->find($id);
    }

    public function rechazar($id)
    {
        $this->traspasoService->rechazar($id);
        return Traspaso::with("origen")->with("destino")->find($id);
    }
}
