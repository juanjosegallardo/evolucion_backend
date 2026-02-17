<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Venta;
use App\Models\Almacen;
use App\Models\VentaArticulo;
use Illuminate\Http\Request;

class VentaArticuloService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }



    public function guardar(Request $request, $id)
    {

    
        DB::transaction(function() use($request,$id) {
            $venta = Venta::find($id);

            
            if(! $venta->estaEnCaptura() && !$venta->estaRechazado()){
                throw new \Exception("No se pueden agregar artículos en este momento de la venta");
            }

            $articulo=Articulo::where("codigo","=",$request->codigo)->first();

            if(!$articulo){
                throw new \Exception("No se encontró un artículo con el código proporcionado.");
            }

            if($request->defectuosos){
                $venta->increment("cantidad_defectuosos", $request->cantidad);
                $venta->articulos()->attach($articulo->id, ["cantidad"=>0, "cantidad_defectuosos"=>$request->cantidad]);
          
            } else {
                $venta->increment("cantidad", $request->cantidad);
                $venta->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
            }

            $venta->actualizarTotalReal();
        });
    }   

    public function eliminar( $id)
    {
        DB::transaction(function() use($id) {
            $venta_articulo = VentaArticulo::find($id);
            $venta = Venta::find($venta_articulo->venta_id);
            
            if(! $venta->estaEnCaptura() && !$venta->estaRechazado()){
                throw new \Exception("No se pueden quitar artículos de la venta en este momento de la venta");
            }

            $updated = Venta::where('id', $venta->id)
                ->where('cantidad', '>=', $venta_articulo->cantidad)
                ->where('cantidad_defectuosos', '>=', $venta_articulo->cantidad_defectuosos)
                ->update([
                    'cantidad' => \DB::raw("cantidad - {$venta_articulo->cantidad}"),
                    'cantidad_defectuosos' => \DB::raw("cantidad_defectuosos - {$venta_articulo->cantidad_defectuosos}")
                ]);

            
            if (!$updated) {
                throw new \Exception("No hay suficientes cantidades en la venta para descontar.");
            }          

            $venta_articulo->delete();
            $venta->actualizarTotalReal();
        });
    }

    
}
