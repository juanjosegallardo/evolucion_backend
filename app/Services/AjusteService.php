<?php

namespace App\Services;
use App\Services\ArticuloAlmacenService;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\Ajuste;
use App\Models\AjusteArticulo;
use App\Enums\EstadoMovimientoAlmacen;
use Illuminate\Validation\ValidationException;
use App\Models\AlmacenArticulo;

class AjusteService
{
    /**
     * Create a new class instance.
     */

    protected $articuloAlmacenService;
    
    public function __construct(ArticuloAlmacenService $articuloAlmacenService)
    {
        $this->articuloAlmacenService = $articuloAlmacenService;
    }   

    public function crear($request)
    {
        return DB::transaction(function() use ($request) {

            $ajuste = new Ajuste();
            $ajuste->almacen_id = $request->almacen_id;
            $ajuste->fecha = $request->fecha;
            $ajuste->save();

            // Obtener artículos con stock (excluyendo eliminados)
            $articulos = DB::table('articulos')
                ->leftJoin('almacen_articulo', function($join) use ($request) {
                    $join->on('articulos.id', '=', 'almacen_articulo.articulo_id')
                        ->where('almacen_articulo.almacen_id', $request->almacen_id);
                })
                ->whereNull('articulos.deleted_at') // 👈 clave
                ->select(
                    'articulos.id',
                    DB::raw('COALESCE(almacen_articulo.cantidad, 0) as cantidad'),
                    DB::raw('COALESCE(almacen_articulo.cantidad_defectuosos, 0) as cantidad_defectuosos')
                )
                ->get();

            // Preparar datos para la tabla pivote
            $syncData = [];

            $total_stock =0;
            $total_defectuosos =0;
            
            foreach ($articulos as $articulo) {
                $total_stock += $articulo->cantidad;
                $total_defectuosos += $articulo->cantidad_defectuosos;
                $syncData[$articulo->id] = [
                    'cantidad' => $articulo->cantidad,
                    'cantidad_defectuosos' => $articulo->cantidad_defectuosos
                ];
            }

            // Insertar en la relación
            $ajuste->articulos()->sync($syncData);
            $ajuste->cantidad =$total_stock;
            $ajuste->cantidad_defectuosos = $total_defectuosos;
            $ajuste->save();
            return $ajuste;
        });
    }

    public function eliminar($ajuste_id)
    {
        DB::transaction(function() use ($ajuste_id) {

            $ajuste = Ajuste::findOrFail($ajuste_id);
            
            if (!$ajuste->estaEnCaptura() && !$ajuste->estaRechazado()) {
                throw ValidationException::withMessages([
                    'estado' => 'El ajuste no puede ser eliminado en el estado actual.',
                ]);
            }
            $ajuste->delete();
          
        });
    }


   public function validar($ajuste_id)
    {
        DB::transaction(function () use ($ajuste_id) {

            $ajuste = Ajuste::findOrFail($ajuste_id);

            if (!$ajuste->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'El ajuste no está solicitado y no puede ser validado.',
                ]);
            }

            $ajuste->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $ajuste->save();

            $ajuste_articulos = AjusteArticulo::where("ajuste_id", $ajuste_id)->get();

            foreach ($ajuste_articulos as $ajuste_articulo) {

                $almacen_articulo = AlmacenArticulo::where("almacen_id", $ajuste->almacen_id)
                    ->where("articulo_id", $ajuste_articulo->articulo_id)
                    ->first();

                $cantidadActual = $almacen_articulo?->cantidad ?? 0;
                $cantidadActualDefectuosos = $almacen_articulo?->cantidad_defectuosos ?? 0;

                $cantidadAjuste = $ajuste_articulo->cantidad;
                $cantidadAjusteDefectuosos = $ajuste_articulo->cantidad_defectuosos;

                // 🔥 Diferencias reales
                $diferencia = $cantidadAjuste - $cantidadActual;
                $diferenciaDefectuosos = $cantidadAjusteDefectuosos - $cantidadActualDefectuosos;

                // 👉 SUMAR
                if ($diferencia > 0 || $diferenciaDefectuosos > 0) {

                    $this->articuloAlmacenService->agregar(
                        $ajuste_articulo->articulo_id,
                        $ajuste->almacen_id,
                        max($diferencia, 0),
                        max($diferenciaDefectuosos, 0),
                        $ajuste
                    );

                }

                // 👉 RESTAR
                if ($diferencia < 0 || $diferenciaDefectuosos < 0) {

                    $this->articuloAlmacenService->descontar(
                        $ajuste_articulo->articulo_id,
                        $ajuste->almacen_id,
                        abs(min($diferencia, 0)),
                        abs(min($diferenciaDefectuosos, 0)),
                        $ajuste
                    );

                }
            }

        });
    }
    

   public function cancelar($ajuste_id)
    {
        DB::transaction(function() use ($ajuste_id) {

            $ajuste = Ajuste::findOrFail($ajuste_id);
            
            if (!$ajuste->estaValidado()) {
                throw ValidationException::withMessages([
                    'estado' => 'El ajuste no está validado y no puede ser cancelado.',
                ]);
            }

            $movimientos = Movimiento::where('movible_id', $ajuste->id)
                ->where('movible_type', Ajuste::class)
                ->lockForUpdate()
                ->get();

            foreach ($movimientos as $movimiento) {

                if ($movimiento->cantidad > 0) {

                    $this->articuloAlmacenService->descontar(
                        $movimiento->articulo_id,
                        $movimiento->almacen_id,
                        $movimiento->cantidad,
                        $movimiento->cantidad_defectuosos,
                        $ajuste
                    );

                } else {

                    $this->articuloAlmacenService->agregar(
                        $movimiento->articulo_id,
                        $movimiento->almacen_id,
                        abs($movimiento->cantidad),
                        $movimiento->cantidad_defectuosos,
                        $ajuste
                    );

                }

            }

            $ajuste->estado = EstadoMovimientoAlmacen::CANCELADO->value;
            $ajuste->save();

        });
    }

    public function rechazar($ajuste_id)
    {
        $ajuste = Ajuste::findOrFail($ajuste_id);

        if (!$ajuste->estaSolicitado()) {
            throw ValidationException::withMessages([
                'estado' => 'El ajuste no esta solicitado y no puede ser rechazado.',
            ]);
        }
        
        $ajuste->estado = EstadoMovimientoAlmacen::RECHAZADO->value;
        $ajuste->save();
    }

    public function solicitar($ajuste_id)
    {
        $ajuste = Ajuste::findOrFail($ajuste_id);

        if (!$ajuste->estaEnCaptura()&& !$ajuste->estaRechazado() ) {
            throw ValidationException::withMessages([
                'estado' => 'El ajuste no puede ser solicitado en este momento',
            ]);
        }
        
        $ajuste->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
        $ajuste->save();
    }
     
}
