<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VentaArticuloService;
use App\Models\VentaArticulo;
use App\Models\Venta;
use App\Models\Articulo;
use Illuminate\Support\Facades\DB;


class VentaArticuloController extends Controller
{
    protected $ventaArticuloService;

    public function __construct(VentaArticuloService $ventaArticuloService)
    {
        $this->ventaArticuloService = $ventaArticuloService;

    }


    public function store(Request $request, $id)
    {
        DB::transaction(function() use($request,$id) {
            $venta = Venta::find($id);
            $articulo=Articulo::where("codigo","=",$request->codigo)->first();
            $venta->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "defectuosos"=>$request->defectuosos]);
            $venta->increment("cantidad", $request->cantidad);

        });
        return Venta::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "defectuosos"])->with("tipoArticulo");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $venta_articulo = VentaArticulo::find($id);
        $venta = Venta::find($venta_articulo->venta_id);
        $venta->decrement("cantidad", $venta_articulo->cantidad);
        $venta_articulo->delete();
        return Venta::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "defectuosos"])->with("tipoArticulo");
        }])->find($venta_articulo->venta_id);
    }
}
