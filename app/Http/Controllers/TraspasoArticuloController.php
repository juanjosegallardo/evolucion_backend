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
        DB::transaction(function() use($request,$id) {;
            $traspaso = Traspaso::find($id);
            $articulo=Articulo::where("codigo","=",$request->codigo)->first();
            if($request->defectuosos){
                $traspaso->articulos()->attach($articulo->id, ["cantidad"=>0, "cantidad_defectuosos"=>$request->cantidad]);
                $traspaso->increment("cantidad_defectuosos", $request->cantidad);
            } else {
                $traspaso->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
                $traspaso->increment("cantidad", $request->cantidad);
            }
           
        });
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $traspaso_articulo = TraspasoArticulo::find($id);

        $traspaso = Traspaso::find($traspaso_articulo->traspaso_id);
        $traspaso->decrement("cantidad", $traspaso_articulo->cantidad);
        $traspaso->decrement("cantidad_defectuosos", $traspaso_articulo->cantidad_defectuosos);
        $traspaso_articulo->delete();
        
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($traspaso->id);
    }

    public function solicitarValidacion($id)
    {
        $traspaso = Traspaso::find($id);
        $traspaso->estado = "SOLICITADO";
        $traspaso->save();
        return $traspaso;
    }   

    public function validar($id)
    {
        $traspaso = Traspaso::find($id);
        $traspaso->estado = "VALIDADO";
        $traspaso->save();
        return $traspaso;
    }

    public function rechazar($id)
    {
        $traspaso = Traspaso::find($id);
        $traspaso->estado = "RECHAZADO";
        $traspaso->save();
        return $traspaso;
    }

}
