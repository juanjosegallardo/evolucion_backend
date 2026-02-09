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
            if($request->defectuosos){
                $carga->articulos()->attach($articulo->id, ["cantidad"=>0, "cantidad_defectuosos"=>$request->cantidad]);
                $carga->increment("cantidad_defectuosos", $request->cantidad);
          
            } else {
                $carga->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
                $carga->increment("cantidad", $request->cantidad);}
        });
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo")->orderByPivot("id","desc");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $carga_articulo = CargaArticulo::find($id);
        $carga = Carga::find($carga_articulo->carga_id);
        $carga->decrement("cantidad", $carga_articulo->cantidad);
        $carga->decrement("cantidad_defectuosos", $carga_articulo->cantidad_defectuosos);
        $carga_articulo->delete();
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo")->orderByPivot("id","desc");
        }])->find($carga_articulo->carga_id);
    }
}
