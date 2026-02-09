<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Carga;
use App\Models\CargaArticulo;
use App\Services\CargaArticuloService;
use Illuminate\Support\Facades\DB;


class CargaArticuloController extends Controller
{
    protected $cargaArticuloService;

    public function __construct(CargaArticuloService $cargaArticuloService)
    {
        $this->cargaArticuloService = $cargaArticuloService;

    }


    public function store(Request $request, $id)
    {
        DB::transaction(function() use($request,$id) {
            $carga = Carga::find($id);
            $articulo=Articulo::where("codigo","=",$request->codigo)->first();
            $carga->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "defectuosos"=>$request->defectuosos]);
            $carga->increment("cantidad", $request->cantidad);
        });
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "defectuosos"])->with("tipoArticulo")->orderByPivot("id","desc");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $carga_articulo = CargaArticulo::find($id);
        $carga = Carga::find($carga_articulo->carga_id);
        $carga->decrement("cantidad", $carga_articulo->cantidad);
        $carga_articulo->delete();
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "defectuosos"])->with("tipoArticulo")->orderByPivot("id","desc");
        }])->find($carga_articulo->carga_id);
    }
}
