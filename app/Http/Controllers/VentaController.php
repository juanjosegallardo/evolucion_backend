<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Services\VentaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VentaController extends Controller
{
    protected $ventaService;
    use AuthorizesRequests;

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
    public function store(StoreVentaRequest $request)
    {
        $venta = $this->ventaService->crear($request->validated());
        return Venta::with("almacen")->with("vendedor")->find($venta->id);
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
        $venta = Venta::find($id);
        $this->authorize("delete",$venta);
        $this->ventaService->eliminar($id);
    }

    public function solicitarValidacion($id)
    {
        $venta = Venta::find($id);
        $this->authorize("solicitar",$venta);
        $this->ventaService->solicitar($id);
        return Venta::with("vendedor")->with("almacen")->find($id);
    }   

    public function validar($id)
    {
        $venta = Venta::find($id);
        $this->authorize("validar",$venta);
        $this->ventaService->validar($id);   
        return Venta::with("vendedor")->with("almacen")->find($id);
    }

    public function rechazar($id)
    {
        $venta = Venta::find($id);
        $this->authorize("rechazar",$venta);
        $this->ventaService->rechazar($id);
        return Venta::with("vendedor")->with("almacen")->find($id);
    }

    public function cancelar($id)
    {
        $venta = Venta::findOrFail($id);
        $this->authorize("cancelar",$venta);
        $this->ventaService->cancelar($id);
        return Venta::with("almacen")->find($id);
    }
}

