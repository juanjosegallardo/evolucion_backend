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

        $this->ventaArticuloService->guardar($request, $id);
        return Venta::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $venta_articulo = VentaArticulo::find($id);
        $this->ventaArticuloService->eliminar($id);
        return Venta::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($venta_articulo->venta_id);
    }
}
