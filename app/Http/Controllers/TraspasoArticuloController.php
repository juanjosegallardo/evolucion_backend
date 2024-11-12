<?php

namespace App\Http\Controllers;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Traspaso;
use App\Models\TraspasoArticulo;
use Illuminate\Http\Request;

class TraspasoArticuloController extends Controller
{
    public function store(Request $request, $id)
    {
        $traspaso = Traspaso::find($id);
        $articulo=Articulo::where("codigo","=",$request->codigo)->first();
        $traspaso->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
        $traspaso->increment("cantidad", $request->cantidad);
        $origen=Almacen::find($traspaso->almacen_origen_id);
        $origen->decrement("cantidad",$request->cantidad);
        
        $destino=Almacen::find($traspaso->almacen_destino_id);
        $destino->increment("cantidad",$request->cantidad);
    
        $almacenArticuloOrigen = $origen->articulos()->where('articulo_id', $articulo->id)->first();

        if ($almacenArticuloOrigen) {
            $almacenArticuloOrigen->pivot->decrement("cantidad", $request->cantidad);
        } 
        else
        {
            $origen->articulos()->attach($articulo->id, ["cantidad"=> -$request->cantidad, "cantidad_defectuosos"=>0]);
        }



        $almacenArticuloDestino = $destino->articulos()->where('articulo_id', $articulo->id)->first();
        if ($almacenArticuloDestino) {
            $almacenArticuloDestino->pivot->increment("cantidad", $request->cantidad);
        } 
        else
        {
            $destino->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
        }

        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($id);
    }

    public function destroy( $id)
    {
        $traspaso_articulo = TraspasoArticulo::find($id);

        $traspaso = Traspaso::find($traspaso_articulo->traspaso_id);
        $traspaso->decrement("cantidad", $traspaso->cantidad);

        $origen=Almacen::find($traspaso->almacen_origen_id);
        $origen->increment("cantidad",$traspaso_articulo->cantidad);

        $destino=Almacen::find($traspaso->almacen_destino_id);
        $destino->decrement("cantidad",$traspaso_articulo->cantidad);

        //agregarle de nuevo al destino

        $almacenArticuloOrigen = $origen->articulos()->where('articulo_id', $traspaso_articulo->articulo_id)->first();
        if ($almacenArticuloOrigen) {
            $almacenArticuloOrigen->pivot->increment("cantidad", $traspaso_articulo->cantidad);
            $almacenArticuloOrigen->pivot->save();
        } 
        else
        {
            $origen->articulos()->attach($articulo->id, ["cantidad"=>$carga_articulo->cantidad, "cantidad_defectuosos"=>0]);
        }

        //descontar nuevamente al destino

        $almacenArticuloDestino = $destino->articulos()->where('articulo_id', $traspaso_articulo->articulo_id)->first();
        if ($almacenArticuloDestino) {
            $almacenArticuloDestino->pivot->decrement("cantidad", $traspaso_articulo->cantidad);
            $almacenArticuloDestino->pivot->save();
        } 
        else
        {
            $destino->articulos()->attach($traspaso_articulo->articulo_id, ["cantidad"=>-$carga_articulo->cantidad, "cantidad_defectuosos"=>0]);
        }

        $traspaso_articulo->delete();
        
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($traspaso->id);
    }
}
