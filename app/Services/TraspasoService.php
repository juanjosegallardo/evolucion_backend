<?php

namespace App\Services;

class TraspasoService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function agregarArticulos($id)
    {
        $traspaso= Traspaso::find($id);

        $articulos_traspaso = $traspaso->articulos;
        $almacen_origen = $traspaso->almacen_origen;
        $almacen_destino = $traspaso->almacen_destino;

        foreach($articulos_traspaso as $articulo_traspaso){

            $almacen_origen->decrement("cantidad",$articulo_traspaso->cantidad);
            $almacen_origen->decrement("cantidad_defectuosos",$articulo_traspaso->cantidad_defectuosos);
            
     
            $almacen_destino->increment("cantidad",$articulo_traspaso->cantidad);
            $almacen_destino->increment("cantidad_defectuosos",$articulo_traspaso->cantidad_defectuosos);
            
            $almacenArticuloDestino = $almacen_destino->articulos()->where('articulo_id', $articulo_traspaso->articulo_id)->first();

            if ($almacenArticuloDestino) {
                $almacenArticuloDestino->pivot->increment("cantidad", $articulo_traspaso->cantidad);
                $almacenArticuloDestino->pivot->increment("cantidad_defectuosos", $articulo_traspaso->cantidad_defectuosos);
                $almacenArticuloDestino->pivot->save();
            } 
            else
            {
                $almacen_destino->articulos()->attach($articulo_traspaso->articulo_id, ["cantidad"=>$articulo_traspaso->cantidad, "cantidad_defectuosos"=>$articulo_traspaso->cantidad_defectuosos]);
            }


            $almacenArticuloOrigen = $almacen_origen->articulos()->where('articulo_id', $articulo_traspaso->articulo_id)->first();
            if ($almacenArticuloOrigen) {
                $almacenArticuloOrigen->pivot->decrement("cantidad", $articulo_traspaso->cantidad);
                $almacenArticuloOrigen->pivot->decrement("cantidad_defectuosos", $articulo_traspaso->cantidad_defectuosos);
                $almacenArticuloOrigen->pivot->save();
            } 
            else
            {
                $almacen_origen->articulos()->attach($articulo_traspaso->articulo_id, ["cantidad"=>0, "cantidad_defectuosos"=>0]);
            }
        }
    }
}
