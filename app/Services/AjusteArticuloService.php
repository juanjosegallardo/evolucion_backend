<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Ajuste;
use App\Models\AjusteArticulo;
use Illuminate\Http\Request;

class AjusteArticuloService  
{
    public function __construct()
    {
        //
    }

    public function guardar(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $ajuste = Ajuste::findOrFail($id);

            if (!$ajuste->estaEnCaptura() && !$ajuste->estaRechazado()) {
                throw new \Exception("No se pueden agregar artículos en este momento del ajuste");
            }

            $articulo = Articulo::where("codigo", $request->codigo)->first();

            if (!$articulo) {
                throw new \Exception("No se encontró un artículo con el código proporcionado.");
            }

            $ajuste->articulos()->attach($articulo->id, [
                "cantidad" => $request->cantidad ?? 0,
                "cantidad_defectuosos" => $request->cantidad_defectuosos ?? 0
            ]);
            $this->recalcularTotales($ajuste);

        });
    }

    public function editar(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $ajuste_articulo = AjusteArticulo::findOrFail($id);
            $ajuste = Ajuste::findOrFail($ajuste_articulo->ajuste_id);

            if (!$ajuste->estaEnCaptura() && !$ajuste->estaRechazado()) {
                throw new \Exception("No se pueden editar artículos en este momento del ajuste");
            }

            $ajuste_articulo->update([
                'cantidad' => $request->pivot["cantidad"] ?? 0,
                'cantidad_defectuosos' =>  $request->pivot["cantidad_defectuosos"]?? 0
            ]);

            // 🔥 recalcular totales
            $this->recalcularTotales($ajuste);

        });
    }

    public function eliminar($id)
    {
        DB::transaction(function () use ($id) {

            $ajuste_articulo = AjusteArticulo::findOrFail($id);
            $ajuste = Ajuste::find($ajuste_articulo->ajuste_id);

            if (!$ajuste->estaEnCaptura() && !$ajuste->estaRechazado()) {
                throw new \Exception("No se pueden quitar artículos en este momento del ajuste");
            }

            $ajuste_articulo->delete();

            // 🔥 recalcular totales
            $this->recalcularTotales($ajuste);

        });
    }

    /**
     * 🔹 Recalcula totales del ajuste
     */
    private function recalcularTotales(Ajuste $ajuste)
    {
        $totales = AjusteArticulo::where('ajuste_id', $ajuste->id)
            ->selectRaw('
                COALESCE(SUM(cantidad),0) as total_cantidad,
                COALESCE(SUM(cantidad_defectuosos),0) as total_defectuosos
            ')
            ->first();

        $ajuste->update([
            'cantidad' => $totales->total_cantidad,
            'cantidad_defectuosos' => $totales->total_defectuosos
        ]);
    }
}