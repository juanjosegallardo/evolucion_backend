<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Services\DevolucionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevolucionController  extends Controller
{
    protected $devolucionService;

    public function __construct(DevolucionService $devolucionService)
    {
        $this->devolucionService= $devolucionService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Devolucion::with("vendedor")->with("almacen")->with("articulos")->orderBy("created_at","desc")->get();
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
        $devolucion = new Devolucion();
        $devolucion->almacen_id = $request->almacen_id;
        $devolucion->vendedor_id =$request->vendedor_id;
        $devolucion->saldo_restante  = $request->saldo_restante;
        $devolucion->notas= $request->notas;
        $devolucion->save();    
        return $devolucion->with("almacen")->with("vendedor")->find($devolucion->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        return Venta::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->with("almacen")->with("vendedor")->find($id);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVentaRequest $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $devolucion = Devolucion::find($id);
        $devolucion->delete();
    }

    public function solicitarValidacion($id)
    {
        $this->devolucionService->solicitar($id);
        return Devolucion::with("vendedor")->with("almacen")->find($id);
    }   

    public function validar($id)
    {
        $this->devolucionService->validar($id);   
        return Devolucion::with("vendedor")->with("almacen")->find($id);
    }

    public function rechazar($id)
    {
        $this->devolucionService->rechazar($id);
        return Devolucion::with("vendedor")->with("almacen")->find($id);
    }
}

