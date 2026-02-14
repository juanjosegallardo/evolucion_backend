<?php

namespace App\Services;
use App\Services\ArticuloAlmacenService;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\Carga;
use App\Models\CargaArticulo;
use App\Enums\EstadoMovimientoAlmacen;
use Illuminate\Validation\ValidationException;

class DevolucionService
{
    /**
     * Create a new class instance.
     */

    protected $articuloAlmacenService;
    
    public function __construct(ArticuloAlmacenService $articuloAlmacenService)
    {
        $this->articuloAlmacenService = $articuloAlmacenService;
    }   

    public function validar($devolucion_id)
    {
        DB::transaction(function() use ($devolucion_id) {

            $devolucion = Devolucion::findOrFail($devolucion_id);
            
            if (!$devolucion->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La devolución no está solicitada y no puede ser validada.',
                ]);
            }
            
            $devolucion->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $devolucion->save();
            $devolucion_articulos = DevolucionArticulo::where("devolucion_id", $devolucion_id)->get();

            foreach($devolucion_articulos as $da){
                $this->articuloAlmacenService->agregar($da->articulo_id, $devolucion->almacen_id, $da->cantidad, $da->cantidad_defectuosos);
            }
        });
    }

    public function rechazar($devolucion_id)
    {
        $devolucion = Devolucion::findOrFail($devolucion_id);

        if (!$devolucion->estaSolicitado()) {
            throw ValidationException::withMessages([
                'estado' => 'La devolución no está solicitada y no puede ser rechazada.',
            ]);
        }
        
        $devolucion->estado = EstadoMovimientoAlmacen::RECHAZADO->value;
        $devolucion->save();
    }

    public function solicitar($devolucion_id)
    {
        $devolucion = Devolucion::findOrFail($devolucion_id);

        if (!$devolucion->estaEnCaptura()) {
            throw ValidationException::withMessages([
                'estado' => 'La devolución no está en en captura y no puede ser solicitada.',
            ]);
        }
        
        $devolucion->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
        $devolucion->save();
    }
     
}
