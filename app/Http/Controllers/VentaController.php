<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Services\VentaService;
use Illuminate\Http\Request;


class VentaController extends Controller
{
    protected $ventaService;

    public function __construct(VentaService $ventaService)
    {
        $this->ventaService= $ventaService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Venta::with("vendedor")->with("almacen")->with("articulos")->get();
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
        $venta = new Venta();
        $venta->almacen_id = $request->almacen_id;
        $venta->vendedor_id =$request->vendedor_id;
        $venta->total = $request->total;
        $venta->enganche = $request->enganche;
        $venta->tipo = $request->tipo;
        $venta->fecha = $request->fecha;
        $this->ventaService->calcularComision($venta);
        $venta->save();

        return $venta->with("almacen")->with("vendedor")->find($venta->id);
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
        $venta= Venta::find($id);
        $venta->delete();
    }
}
