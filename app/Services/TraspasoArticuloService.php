<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Traspaso;
use App\Models\Almacen;
use App\Models\TraspasoArticulo;
use Illuminate\Http\Request;

class TraspasoArticuloService
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
            $traspaso = Traspaso::find($id);

            if(! $traspaso->estaEnCaptura()){
                throw new \Exception("El traspaso no está en captura y no se pueden agregar artículos.");
            }

            $articulo=Articulo::where("codigo","=",$request->codigo)->first();

            
            if(!$articulo){
                throw new \Exception("No se encontró un artículo con el código proporcionado.");
            }

            if($request->defectuosos){
                $traspaso->increment("cantidad_defectuosos", $request->cantidad);
                $traspaso->articulos()->attach($articulo->id, ["cantidad"=>0, "cantidad_defectuosos"=>$request->cantidad]);
          
            } else {
                $traspaso->increment("cantidad", $request->cantidad);
                $traspaso->articulos()->attach($articulo->id, ["cantidad"=>$request->cantidad, "cantidad_defectuosos"=>0]);
            }

        });
    }   

    public function eliminar( $id)
    {
        DB::transaction(function() use($id) {
            $traspaso_articulo = TraspasoArticulo::find($id);
            $traspaso = Traspaso::find($traspaso_articulo->traspaso_id);
            if(! $traspaso->estaEnCaptura()){
                throw new \Exception("El traspaso no está en captura y no se pueden quitar artículos.");
            }

            $updated = Traspaso::where('id', $traspaso->id)
                ->where('cantidad', '>=', $traspaso_articulo->cantidad)
                ->where('cantidad_defectuosos', '>=', $traspaso_articulo->cantidad_defectuosos)
                ->update([
                    'cantidad' => \DB::raw("cantidad - {$traspaso_articulo->cantidad}"),
                    'cantidad_defectuosos' => \DB::raw("cantidad_defectuosos - {$traspaso_articulo->cantidad_defectuosos}")
                ]);

            if (!$updated) {
                throw new \Exception("No hay suficientes cantidades en el traspaso para descontar.");
            }

            $traspaso_articulo->delete();
        });
    }
    
}
