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
            if($request->defectuosos){
                $traspaso->articulos()->attach($request->articulo_id, ["cantidad"=>0, "cantidad_defectuosos"=>$request->cantidad]);
          
            } else {
                $traspaso->articulos()->attach($request->articulo_id, ["cantidad"=>$request->cantidad, "defectuosos"=>0]);
            }

            $traspaso->increment("cantidad", $request->cantidad);
           
        });
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
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
