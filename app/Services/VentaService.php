<?php

namespace App\Services;
use App\Services\ArticuloAlmacenService;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\Venta;
use App\Models\VentaArticulo;
use App\Enums\EstadoMovimientoAlmacen;
use Illuminate\Validation\ValidationException;

class VentaService
{
    /**
     * Create a new class instance.
     */

    protected $articuloAlmacenService;
    
    public function __construct(ArticuloAlmacenService $articuloAlmacenService)
    {
        $this->articuloAlmacenService = $articuloAlmacenService;
    } 


    public function eliminar($venta_id)
    {
        DB::transaction(function() use ($venta_id) {

            $venta = Venta::findOrFail($venta_id);
            
            if (!$venta->estaEnCaptura() && !$venta->estaRechazado() ) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no puede ser eliminada en el estado actual.',
                ]);
            }
            
            $venta->delete();
          
        });
    }

    public function validar(int $venta_id): void
    {
        DB::transaction(function() use ($venta_id) {
            $venta = Venta::findOrFail($venta_id);
            if (!$venta->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no está solicitada y no puede ser validada.',
                ]);
            }
            
            $venta_articulos = VentaArticulo::where("venta_id", $venta_id)->get();

            foreach($venta_articulos as $venta_articulo){
                $this->articuloAlmacenService->descontar($venta_articulo->articulo_id, $venta->almacen_id, $venta_articulo->cantidad, $venta_articulo->cantidad_defectuosos);
            }

            $venta->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $venta->save();
        });
     
    }   

    public function rechazar(int $venta_id): void
    {
        DB::transaction(function() use ($venta_id) {
            $venta = Venta::findOrFail($venta_id);

            if (!$venta->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no está solicitada y no puede ser rechazada.',
                ]);
            }
            $venta->estado = EstadoMovimientoAlmacen::RECHAZADO->value;
            $venta->save();
        });
    }   

    public function solicitar(int $venta_id): void
    {
        DB::transaction(function() use ($venta_id) {
            $venta = Venta::findOrFail($venta_id);

            if (!$venta->estaEnCaptura()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no está en captura y no puede ser solicitada.',
                ]);
            }
            $venta->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
            $venta->save();
        });
    }

}
