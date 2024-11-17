<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Carga;
use App\Models\Almacen;
use App\Models\CargaArticulo;

class CargaArticuloService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function agregar($carga_id, $codigo, $cantidad)
    {
        DB::transaction(function() use( $carga_id, $codigo, $cantidad) 
        {
            $carga = Carga::find($carga_id);
            $articulo=Articulo::where("codigo","=",$codigo)->first();
            $carga->articulos()->attach($articulo->id, ["cantidad"=>$cantidad, "cantidad_defectuosos"=>0]);
            $carga->increment("cantidad", $cantidad);
            $almacen=Almacen::find($carga->almacen_id);
            $almacen->increment("cantidad",$cantidad);
            $articulo->increment("cantidad",$cantidad);
            
            $almacenArticulo = $almacen->articulos()->where('articulo_id', $articulo->id)->first();
            if ($almacenArticulo) 
            {
                $almacenArticulo->pivot->increment("cantidad", $cantidad);
                $almacenArticulo->pivot->save();
            } 
            else
            {
                $almacen->articulos()->attach($articulo->id, ["cantidad"=>$cantidad, "cantidad_defectuosos"=>0]);
            }
        });
    }

    public function quitar($id)
    {
        DB::transaction(function() use($id) 
        {
            $carga_articulo = CargaArticulo::find($id);
            $articulo=Articulo::find($carga_articulo->articulo_id);
            $articulo->decrement("cantidad",$carga_articulo->cantidad);
            $carga = Carga::find($carga_articulo->carga_id);
            $carga->decrement("cantidad", $carga_articulo->cantidad);
            $almacen=Almacen::find($carga->almacen_id);
            $almacen->decrement("cantidad",$carga_articulo->cantidad);

            $almacenArticulo = $almacen->articulos()->where('articulo_id', $articulo->id)->first();

            if ($almacenArticulo) {
                $almacenArticulo->pivot->decrement("cantidad", $carga_articulo->cantidad);
                $almacenArticulo->pivot->save();
            } 
            else
            {
                $almacen->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
            }

        

            $carga_articulo->delete();
        });

    }
}
