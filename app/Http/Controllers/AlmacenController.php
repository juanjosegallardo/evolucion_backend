<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Articulo;
use App\Http\Requests\StoreAlmacenRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateAlmacenRequest;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Almacen::visiblePara(auth()->user())->with("responsable")->get();
    }

    public function mostrarTodos()
    {
        return Almacen::with("responsable")->get();
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
        $almacen->save();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $almacen = Almacen::with("responsable")->findOrFail($id);

        $articulos = Articulo::query()
            ->conExistenciaEn($id)
            ->with("tipoArticulo")
            ->get()
            ->sortBy(fn($a) => $a->tipoArticulo->nombre ?? '')
            ->values();

        $almacen->articulos = $articulos;

        return $almacen;
    }

    public function stock()
    {

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
        $almacen->user_responsable_id = $request->user_responsable_id;
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
