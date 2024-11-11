<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Carga;
use App\Models\CargaArticulo;

class CargaArticuloController extends Controller
{
    public function store(Request $request, $id)
    {
        $carga = Carga::find($id);
        $articulo=Articulo::where("codigo","=",$request->codigo)->first();
        $carga->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
        $carga->increment("cantidad", $request->cantidad);
        $almacen=Almacen::find($carga->almacen_id);
        $almacen->increment("cantidad",$request->cantidad);
        $articulo->increment("cantidad",$request->cantidad);
        
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $carga_articulo = CargaArticulo::find($id);
        $articulo=Articulo::find($carga_articulo->articulo_id);
        $articulo->decrement("cantidad",$carga_articulo->cantidad);
        $carga = Carga::find($carga_articulo->carga_id);
        $carga->decrement("cantidad", $carga_articulo->cantidad);
        $almacen=Almacen::find($carga->almacen_id);
        $almacen->decrement("cantidad",$carga_articulo->cantidad);

        $carga_articulo->delete();
        
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($carga->id);
    }
}
