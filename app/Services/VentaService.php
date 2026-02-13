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

    public function validar(int $venta_id): Venta
    {
        DB::transaction(function() use ($venta_id) {
            $venta = Venta::findOrFail($venta_id);
            if (!$venta->estaEnCaptura()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no está en en captura y no puede ser validada.',
                ]);
            }
            $this->articuloAlmacenService->descontar($venta->articulo_id, $venta->almacen_id, $venta->cantidad, $venta->cantidad_defectuosos);
            $venta->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $venta->save();
        });
     
    }   

    public function rechazar(int $venta_id): void
    {
        DB::transaction(function() use ($venta_id) {
            $venta = Venta::findOrFail($venta_id);

            if (!$venta->estaEnCaptura()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no está en captura y no puede ser rechazada.',
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
