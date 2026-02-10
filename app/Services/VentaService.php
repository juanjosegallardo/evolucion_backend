<?php

namespace App\Services;
use App\Models\Venta;


class VentaService
{
    /**
     * Create a new class instance.
     */

    public function __construct()
    {
        //
    }

    public function calcularComision(Venta $venta)
    {
        if($venta->tipo=="CREDITO")
        {
            $venta->porcentaje = 10;
            $venta->comision = ($venta->porcentaje/100)*$venta->total;
            $venta->a_pagar = $venta->comision-$venta->enganche;
        }
        if($venta->tipo=="CONTADO")
        {
            $venta->enganche = 0;
            $venta->porcentaje=0;
            $venta->comision =0;
            $venta->a_pagar = 0;
        }

    }



    public function agregarArticulos($venta_id)
    {
        $articulos_venta = VentaArticulo::where("venta_id", $venta_id)->get();
        foreach($articulos_venta as $articulo_venta){
            $articulo = Articulo::find($articulo_venta->articulo_id);
            $almacen = Almacen::find($articulo->almacen_id);

            $almacen->decrement("cantidad",$articulo_venta->cantidad);
            $almacen->decrement("cantidad_defectuosos",$articulo_venta->cantidad_defectuosos);
            
            $almacenArticulo = $almacen->articulos()->where('articulo_id', $articulo->id)->first();

            if ($almacenArticulo) {
                $almacenArticulo->pivot->decrement("cantidad", $articulo_venta->cantidad);
                $almacenArticulo->pivot->decrement("cantidad_defectuosos", $articulo_venta->cantidad_defectuosos);
                $almacenArticulo->pivot->save();
            } 
            else
            {
                $almacen->articulos()->attach($articulo->id, ["cantidad"=>$articulo_venta->cantidad, "cantidad_defectuosos"=>$articulo_venta->cantidad_defectuosos]);
            }
        }

    }

    function quitarArticulos($venta_id)
    {
        $articulos_venta = VentaArticulo::where("venta_id", $venta_id)->get();
        foreach($articulos_venta as $articulo_venta){
            $articulo = Articulo::find($articulo_venta->articulo_id);
            $almacen = Almacen::find($articulo->almacen_id);

            $almacen->increment("cantidad",$articulo_venta->cantidad);
            $almacen->increment("cantidad_defectuosos",$articulo_venta->cantidad_defectuosos);
            
            $almacenArticulo = $almacen->articulos()->where('articulo_id', $articulo->id)->first();

            if ($almacenArticulo) {
                $almacenArticulo->pivot->increment("cantidad", $articulo_venta->cantidad);
                $almacenArticulo->pivot->increment("cantidad_defectuosos", $articulo_venta->cantidad_defectuosos);
                $almacenArticulo->pivot->save();
            } 
        }

    }

}
