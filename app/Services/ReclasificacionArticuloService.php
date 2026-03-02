<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Reclasificacion;
use App\Models\Almacen;
use App\Models\ReclasificacionArticulo;
use Illuminate\Http\Request;

class ReclasificacionArticuloService  
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
            $reclasificacion = Reclasificacion::find($id);

            if(! $reclasificacion->estaEnCaptura() && !$reclasificacion->estaRechazado()){
                throw new \Exception("No se pueden agregar artículos en este momento de la reclasificación");
            }

            $articulo=Articulo::where("codigo","=",$request->codigo)->first();

            
            if(!$articulo){
                throw new \Exception("No se encontró un artículo con el código proporcionado.");
            }

            if($request->defectuosos){
                $reclasificacion->increment("cantidad_defectuosos", $request->cantidad);
                $reclasificacion->articulos()->attach($articulo->id, ["cantidad"=>0, "cantidad_defectuosos"=>$request->cantidad]);
          
            } else {
                $reclasificacion->increment("cantidad", $request->cantidad);
                $reclasificacion->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
            }

        });
    }   

    public function eliminar( $id)
    {
        DB::transaction(function() use($id) {
            $reclasificacion_articulo = ReclasificacionArticulo::find($id);
            $reclasificacion = Reclasificacion::find($reclasificacion_articulo->reclasificacion_id);
            if(! $reclasificacion->estaEnCaptura() && !$reclasificacion->estaRechazado()){
                throw new \Exception("No se pueden quitar artículos en este momento de la reclasificación");
            }

            $updated = Reclasificacion::where('id', $reclasificacion->id)
                ->where('cantidad', '>=', $reclasificacion_articulo->cantidad)
                ->where('cantidad_defectuosos', '>=', $reclasificacion_articulo->cantidad_defectuosos)
                ->update([
                    'cantidad' => \DB::raw("cantidad - {$reclasificacion_articulo->cantidad}"),
                    'cantidad_defectuosos' => \DB::raw("cantidad_defectuosos - {$reclasificacion_articulo->cantidad_defectuosos}")
                ]);

            
            if (!$updated) {
                throw new \Exception("No hay suficientes cantidades en la reclasificación para descontar.");
            }
            $reclasificacion_articulo->delete();
        });
    }
    
}
