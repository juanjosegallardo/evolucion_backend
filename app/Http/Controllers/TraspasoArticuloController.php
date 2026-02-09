<?php

namespace App\Http\Controllers;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Traspaso;
use App\Models\TraspasoArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraspasoArticuloController extends Controller
{
    public function store(Request $request, $id)
    {
        DB::transaction(function() use($request,$id) {

            $traspaso = Traspaso::find($id);
            $traspaso->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad,"defectuosos"=>$request->defectuosos]);
            $traspaso->increment("cantidad", $request->cantidad);
           
        });
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "defectuosos"])->with("tipoArticulo");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $traspaso_articulo = TraspasoArticulo::find($id);

        $traspaso = Traspaso::find($traspaso_articulo->traspaso_id);
        $traspaso->decrement("cantidad", $traspaso->cantidad);
        $traspaso_articulo->delete();
        
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "defectuosos"])->with("tipoArticulo");
        }])->find($traspaso->id);
    }
}
