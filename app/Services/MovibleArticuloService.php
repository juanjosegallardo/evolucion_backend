<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Articulo;

class MovibleArticuloService
{

    public function obtenerArticulos($movibleClass, $id)
    {
        return $movibleClass::with([
            "articulos" => function ($q) {
                $q->withPivot(["id", "cantidad", "cantidad_defectuosos"])
                ->with("tipoArticulo")
                ->join('tipo_articulos', 'articulos.tipo_articulo_id', '=', 'tipo_articulos.id')
                ->orderBy('tipo_articulos.nombre', 'asc')
                ->select('articulos.*');
            }
        ])->find($id);
    }

    
    public function guardar($pivotClass,$movibleClass, $id, $request)
    {
        return DB::transaction(function() use ($pivotClass, $movibleClass, $id, $request) {

            $movible = $movibleClass::findOrFail($id);

            if(! $movible->estaEnCaptura() && ! $movible->estaRechazado()){
                throw new \Exception("No se pueden agregar artículos en este momento");
            }

            $articulo = Articulo::where("codigo", $request->codigo)->first();

            if(!$articulo){
                throw new \Exception("No se encontró un artículo con el código proporcionado.");
            }

            $movible->increment("cantidad_defectuosos", $request->cantidad_defectuosos);
            $movible->increment("cantidad", $request->cantidad);

            $movible->articulos()->attach($articulo->id, [
                "cantidad" => $request->cantidad,
                "cantidad_defectuosos" => $request->cantidad_defectuosos
            ]);

          //  $this-> recalcularTotales($movibleClass , $pivotClass, $movible, $movible->id);
            return $this->obtenerArticulos($movibleClass, $movible->id);
        });
    }

    public function eliminar($pivotClass, $movibleClass, $id)
    { 
        return DB::transaction(function() use ($pivotClass, $movibleClass, $id) {

            $movible_articulo = $pivotClass::findOrFail($id);
            $foreignKey = $movibleClass::morph()."_id";
            $movible = $movibleClass::findOrFail($movible_articulo->$foreignKey);

            if(! $movible->estaEnCaptura() && ! $movible->estaRechazado()){
                throw new \Exception("No se pueden quitar artículos en este momento");
            }

            $updated = $movibleClass::where('id', $movible->id)
                ->where('cantidad', '>=', $movible_articulo->cantidad)
                ->where('cantidad_defectuosos', '>=', $movible_articulo->cantidad_defectuosos)
                ->update([
                    'cantidad' => DB::raw("cantidad - {$movible_articulo->cantidad}"),
                    'cantidad_defectuosos' => DB::raw("cantidad_defectuosos - {$movible_articulo->cantidad_defectuosos}")
                ]);

            if (!$updated) {
                throw new \Exception("No hay suficientes cantidades.");
            }

            $movible_articulo->delete();
            $this-> recalcularTotales($movibleClass , $pivotClass, $movible, $foreignKey);

            return $this->obtenerArticulos($movibleClass, $movible->id);
        });
    }


    private function recalcularTotales($movibleClass ,$pivotClass, $movible, $foreignKey)
    {

        $totales = $pivotClass::where($foreignKey, $movible->id)
            ->selectRaw('
                COALESCE(SUM(cantidad),0) as cantidad,
                COALESCE(SUM(cantidad_defectuosos),0) as cantidad_defectuosos
            ')
            ->first();

        $movible->update([
            'cantidad' => $totales->cantidad,
            'cantidad_defectuosos' => $totales->cantidad_defectuosos
        ]);

        if (method_exists($movible, 'actualizarTotalReal')) {
            $movible->actualizarTotalReal();
        }
    }



    public function editar($pivotClass, $movibleClass, $request, $id)
    {
        return DB::transaction(function () use ($pivotClass, $movibleClass, $request, $id) {
            $movible_articulo = $pivotClass::findOrFail($id);
            $foreignKey = $movibleClass::morph()."_id";
            $movible = $movibleClass::findOrFail($movible_articulo->$foreignKey);

            if (!$movible->estaEnCaptura() && !$movible->estaRechazado()) {
                throw new \Exception("No se pueden editar artículos en este momento");
            }

            $movible_articulo->update([
                'cantidad' => $request->pivot["cantidad"] ?? 0,
                'cantidad_defectuosos' => $request->pivot["cantidad_defectuosos"] ?? 0
            ]);

            $this-> recalcularTotales($movibleClass ,$pivotClass, $movible, $foreignKey);
            
            return $this->obtenerArticulos($movibleClass, $movible->id);

        });
    }
}