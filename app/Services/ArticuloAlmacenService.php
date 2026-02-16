<?php
namespace App\Services;

use App\Models\AlmacenArticulo;
use App\Models\Articulo;
use App\Models\Almacen;
use Illuminate\Support\Facades\DB;

class ArticuloAlmacenService
{
    /**
     * Agrega stock al almacén
     */
    public function agregar(
        int $articuloId,
        int $almacenId,
        int $cantidad,
        int $cantidadDefectuosos = 0
    ): void {

        if ($cantidad < 0 || $cantidadDefectuosos < 0) {
            throw new \Exception("Las cantidades no pueden ser negativas");
        }

        $registro = AlmacenArticulo::where('articulo_id', $articuloId)
            ->where('almacen_id', $almacenId)
            ->lockForUpdate()
            ->first();


        $articulo =  Articulo::find($articuloId);
        
        if (!$articulo) {
            throw new \Exception("Artículo no encontrado");
        }

        $almacen = Almacen::find($almacenId);
        if (!$almacen) {    
            throw new \Exception("Almacén no encontrado");
        }   

        $almacen->increment('cantidad', $cantidad);
        $almacen->increment('cantidad_defectuosos', $cantidadDefectuosos);

        $articulo->increment('cantidad', $cantidad);
        $articulo->increment('cantidad_defectuosos', $cantidadDefectuosos);

        $tipo_articulo = $articulo->tipoArticulo;
        $tipo_articulo->increment('cantidad', $cantidad);
        $tipo_articulo->increment('cantidad_defectuosos', $cantidadDefectuosos);
        
        if ($registro) {

            $registro->increment('cantidad', $cantidad);
            $registro->increment('cantidad_defectuosos', $cantidadDefectuosos);

        } else {

            AlmacenArticulo::create([
                'articulo_id' => $articuloId,
                'almacen_id' => $almacenId,
                'cantidad' => $cantidad,
                'cantidad_defectuosos' => $cantidadDefectuosos,
            ]);
        }
    }

    /**
     * Descuenta stock (buenos y/o defectuosos) de forma atómica
     */
    
    public function descontar(
    int $articuloId,
    int $almacenId,
    int $cantidad = 0,
    int $cantidadDefectuosos = 0
): void {

        if ($cantidad < 0 || $cantidadDefectuosos < 0) {
            throw new \Exception("Las cantidades no pueden ser negativas");
        }


        $articulo =  Articulo::find($articuloId)->with("tipoArticulo")->first();

        // 1️⃣ Descontar del pivot (almacen_articulo)
        $pivotUpdated = AlmacenArticulo::where('articulo_id', $articuloId)
            ->where('almacen_id', $almacenId)
            ->where('cantidad', '>=', $cantidad)
            ->where('cantidad_defectuosos', '>=', $cantidadDefectuosos)
            ->update([
                'cantidad' => DB::raw("cantidad - {$cantidad}"),
                'cantidad_defectuosos' => DB::raw("cantidad_defectuosos - {$cantidadDefectuosos}")
            ]);

        if (!$pivotUpdated) {

            $almacenArticulo = AlmacenArticulo::where('articulo_id', $articuloId)
                ->where('almacen_id', $almacenId)
                ->first();

            $disponiblesBuenos = $almacenArticulo ? $almacenArticulo->cantidad : 0;
            $disponiblesDefectuosos = $almacenArticulo ? $almacenArticulo->cantidad_defectuosos : 0;

            
            throw new \Exception(
                "Stock insuficiente en el almacén del artículo {$articulo->tipoArticulo->nombre} {$articulo->nombre}. 
                Requeridos: {$cantidad} buenos y {$cantidadDefectuosos} defectuosos. 
                Disponibles: {$disponiblesBuenos} buenos y {$disponiblesDefectuosos} defectuosos."
            );


        }

        // 2️⃣ Descontar del artículo global
        $articuloUpdated = Articulo::where('id', $articuloId)
            ->where('cantidad', '>=', $cantidad)
            ->where('cantidad_defectuosos', '>=', $cantidadDefectuosos)
            ->update([
                'cantidad' => DB::raw("cantidad - {$cantidad}"),
                'cantidad_defectuosos' => DB::raw("cantidad_defectuosos - {$cantidadDefectuosos}")
            ]);


        $tipoArticuloUpdated = $articulo->tipoArticulo()->where('id', $articulo->tipo_articulo_id)
            ->where('cantidad', '>=', $cantidad)
            ->where('cantidad_defectuosos', '>=', $cantidadDefectuosos)
            ->update([
                'cantidad' => DB::raw("cantidad - {$cantidad}"),
                'cantidad_defectuosos' => DB::raw("cantidad_defectuosos - {$cantidadDefectuosos}")
            ]);
        
        if (!$articuloUpdated) {
            throw new \Exception("Stock global del artículo insuficiente");
        }

        if (!$tipoArticuloUpdated) {
            throw new \Exception("Stock global del tipo de artículo insuficiente");
        }

        // 3️⃣ Descontar del almacén global
        $almacenUpdated = Almacen::where('id', $almacenId)
            ->where('cantidad', '>=', $cantidad)
            ->where('cantidad_defectuosos', '>=', $cantidadDefectuosos)
            ->update([
                'cantidad' => DB::raw("cantidad - {$cantidad}"),
                'cantidad_defectuosos' => DB::raw("cantidad_defectuosos - {$cantidadDefectuosos}")
            ]);

        if (!$almacenUpdated) {
            throw new \Exception("Stock total del almacén insuficiente");
        }


    }
}
