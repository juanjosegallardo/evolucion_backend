<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Services\VentaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return Venta::visiblePara(auth()->user())->with("vendedor")->with("almacen")->with("articulos")->orderBy("created_at","desc")->get();
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
        $venta->user_vendedor_id =$request->user_vendedor_id;
        $venta->total = $request->total;
        $venta->enganche = $request->enganche;
        $venta->tipo = $request->tipo;
        $venta->fecha = $request->fecha;
        $venta->notas= $request->notas;
        $venta->nombre_cliente = $request->nombre_cliente;
        $venta->calcularComision();
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
        $this->ventaService->eliminar($id);
    }

    public function solicitarValidacion($id)
    {
        $this->ventaService->solicitar($id);
        return Venta::with("vendedor")->with("almacen")->find($id);
    }   

    public function validar($id)
    {
        $this->ventaService->validar($id);   
        return Venta::with("vendedor")->with("almacen")->find($id);
    }

    public function rechazar($id)
    {
        $this->ventaService->rechazar($id);
        return Venta::with("vendedor")->with("almacen")->find($id);
    }
}

