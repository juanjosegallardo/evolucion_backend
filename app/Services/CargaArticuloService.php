<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Carga;
use App\Models\Almacen;
use App\Models\CargaArticulo;
use Illuminate\Http\Request;

class CargaArticuloService  
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
            $carga = Carga::find($id);

            if(! $carga->estaEnCaptura() && !$carga->estaRechazado()){
                throw new \Exception("No se pueden agregar artículos en este momento de la carga");
            }

            $articulo=Articulo::where("codigo","=",$request->codigo)->first();

            
            if(!$articulo){
                throw new \Exception("No se encontró un artículo con el código proporcionado.");
            }

            if($request->defectuosos){
                $carga->increment("cantidad_defectuosos", $request->cantidad);
                $carga->articulos()->attach($articulo->id, ["cantidad"=>0, "cantidad_defectuosos"=>$request->cantidad]);
          
            } else {
                $carga->increment("cantidad", $request->cantidad);
                $carga->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
            }

        });
    }   

    public function eliminar( $id)
    {
        DB::transaction(function() use($id) {
            $carga_articulo = CargaArticulo::find($id);
            $carga = Carga::find($carga_articulo->carga_id);
            if(! $carga->estaEnCaptura() && !$carga->estaRechazado()){
                throw new \Exception("No se pueden quitar artículos en este momento de la carga");
            }

            $updated = Carga::where('id', $carga->id)
                ->where('cantidad', '>=', $carga_articulo->cantidad)
                ->where('cantidad_defectuosos', '>=', $carga_articulo->cantidad_defectuosos)
                ->update([
                    'cantidad' => \DB::raw("cantidad - {$carga_articulo->cantidad}"),
                    'cantidad_defectuosos' => \DB::raw("cantidad_defectuosos - {$carga_articulo->cantidad_defectuosos}")
                ]);

            
            if (!$updated) {
                throw new \Exception("No hay suficientes cantidades en la carga para descontar.");
            }
            $carga_articulo->delete();
        });
    }
    
}
