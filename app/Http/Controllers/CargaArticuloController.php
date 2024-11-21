<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Carga;
use App\Models\CargaArticulo;
use App\Services\CargaArticuloService;

class CargaArticuloController extends Controller
{
    protected $cargaArticuloService;

    public function __construct(CargaArticuloService $cargaArticuloService)
    {
        $this->cargaArticuloService = $cargaArticuloService;

    }


    public function store(Request $request, $id)
    {
        $this->cargaArticuloService->agregar($id, $request->codigo, $request->cantidad);
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo")->orderByPivot("id","asc");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $carga_articulo = CargaArticulo::find($id);
        $this->cargaArticuloService->quitar($id);
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo")->orderByPivot("id","asc");
        }])->find($carga_articulo->carga_id);
    }
}
