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

class CargaService
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

            $ajuste = Carga::findOrFail($ajuste_id);

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
                $cantidadAjuste = $ajuste_articulo->cantidad;

                $diferencia = $cantidadAjuste - $cantidadActual;

                if ($diferencia > 0) {

                    $this->articuloAlmacenService->agregar(
                        $ajuste_articulo->articulo_id,
                        $ajuste->almacen_id,
                        $diferencia,
                        $ajuste_articulo->cantidad_defectuosos,
                        $ajuste
                    );

                } elseif ($diferencia < 0) {

                    $this->articuloAlmacenService->descontar(
                        $ajuste_articulo->articulo_id,
                        $ajuste->almacen_id,
                        abs($diferencia),
                        $ajuste_articulo->cantidad_defectuosos,
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
                    'estado' => 'La carga no está validada y no puede ser cancelada.',
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
        
        $carga->estado = EstadoMovimientoAlmacen::RECHAZADO->value;
        $carga->save();
    }

    public function solicitar($ajuste_id)
    {
        $ajuste = Carga::findOrFail($ajuste);

        if (!$ajuste->estaEnCaptura()&& !$ajuste->estaRechazado() ) {
            throw ValidationException::withMessages([
                'estado' => 'El ajuste no puede ser solicitado en este momento',
            ]);
        }
        
        $ajuste->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
        $ajuste->save();
    }
     
}
