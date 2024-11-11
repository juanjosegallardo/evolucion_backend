<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use App\Http\Requests\StoreCargaRequest;
use App\Http\Requests\UpdateCargaRequest;
use Illuminate\Http\Request;

class CargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Carga::with("almacen")->with("articulos")->orderBy("created_at", "desc")->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $carga = new Carga();
        $carga->almacen_id = $request->almacen_id;
        $carga->save();

        return Carga::with("almacen")->find($carga->id);//hay que regresar with articulos

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->with("almacen")->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carga $carga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargaRequest $request, Carga $carga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $carga = Carga::findOrFail($id);
        $carga->delete();
    }
}
