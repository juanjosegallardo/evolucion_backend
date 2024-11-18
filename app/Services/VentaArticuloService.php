<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Venta;
use App\Models\Almacen;
use App\Models\VentaArticulo;

class VentaArticuloService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function agregar($venta_id, $codigo, $cantidad)
    {
        DB::transaction(function() use( $venta_id, $codigo, $cantidad) 
        {
            $venta = Venta::find($venta_id);
            $articulo=Articulo::where("codigo","=",$codigo)->first();
            $venta->articulos()->attach($articulo->id, ["cantidad"=>$cantidad, "cantidad_defectuosos"=>0]);
            $venta->increment("cantidad", $cantidad);
            $almacen=Almacen::find($venta->almacen_id);
            $almacen->decrement("cantidad",$cantidad);
            $articulo->decrement("cantidad",$cantidad);
            
            $almacenArticulo = $almacen->articulos()->where('articulo_id',"=", $articulo->id)->first();
            if ($almacenArticulo) 
            {
                $almacenArticulo->pivot->decrement("cantidad", $cantidad);
            } 
            else
            {
                $almacen->articulos()->attach($articulo->id, ["cantidad"=>-$cantidad, "cantidad_defectuosos"=>0]);
            }
        });
    }

    public function quitar($id)
    {
        DB::transaction(function() use($id) 
        {
            $venta_articulo = VentaArticulo::find($id);
            $articulo=Articulo::find($venta_articulo->articulo_id);
            $articulo->increment("cantidad",$venta_articulo->cantidad);
            $venta = Venta::find($venta_articulo->venta_id);
            $venta->decrement("cantidad", $venta_articulo->cantidad);
            $almacen=Almacen::find($venta->almacen_id);
            $almacen->increment("cantidad",$venta_articulo->cantidad);

            $almacenArticulo = $almacen->articulos()->where('articulo_id', $articulo->id)->first();

            if ($almacenArticulo) {
                $almacenArticulo->pivot->increment("cantidad", $venta_articulo->cantidad);
                $almacenArticulo->pivot->save();
            } 
            else
            {
                $almacen->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
            }

        

            $venta_articulo->delete();
        });

    }
}
