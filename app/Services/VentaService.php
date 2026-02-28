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



    public function crear(array $data)
    {
        return DB::transaction(function() use ($data) {
            $venta = new Venta();
            $venta->fill($data);

            $venta->calcularComision();

            if($venta['tipo'] === 'CREDITO' && $venta->enganche < 0){
                throw ValidationException::withMessages([
                    'enganche' => 'El enganche debe ser mayor o igual a 0 para ventas a crédito.',
                ]);
            }
            
            if($venta['tipo'] === 'CREDITO' && $venta["nombre_cliente"] == ""){
                throw ValidationException::withMessages([
                    'nombre_cliente' => 'El nombre del cliente es obligatorio para ventas a crédito.',
                ]);
            }
            
                    
            if($venta['fecha']->isWeekend() || $venta['fecha']->isBefore(now()->subWeek())){
                throw ValidationException::withMessages([
                    'fecha' => 'La fecha tiene que estar entre lunes y viernes y no debe ser anterior una semana a la fecha actual.',
                ]);
            }
            
            
            $venta->save();
            return $venta;
        });
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
                    'estado' => 'La venta no puede ser validada  en el estado actual.',
                ]);
            }
            
            $venta->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $venta->save();
            $venta_articulos = VentaArticulo::where("venta_id", $venta_id)->get();

            foreach($venta_articulos as $venta_articulo){
                $this->articuloAlmacenService->descontar($venta_articulo->articulo_id, $venta->almacen_id, $venta_articulo->cantidad, $venta_articulo->cantidad_defectuosos,$venta);
            }

     
        });
     
    }   

    
    public function cancelar(int $venta_id): void
    {
        DB::transaction(function() use ($venta_id) {
            $venta = Venta::findOrFail($venta_id);
            if (!$venta->estaValidado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta  no puede ser cancelada en el estado actual.'
                ]);
            }
            
            $venta_articulos = VentaArticulo::where("venta_id", $venta_id)->get();

            foreach($venta_articulos as $venta_articulo){
                $this->articuloAlmacenService->agregar($venta_articulo->articulo_id, $venta->almacen_id, $venta_articulo->cantidad, $venta_articulo->cantidad_defectuosos,$venta);
            }

            $venta->estado = EstadoMovimientoAlmacen::CANCELADO->value;
            $venta->save();
        });
     
    }   

    public function rechazar(int $venta_id): void
    {
        DB::transaction(function() use ($venta_id) {
            $venta = Venta::findOrFail($venta_id);

            if (!$venta->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no puede ser rechazada en el estado actual.',
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

            if (!$venta->estaEnCaptura() && !$venta->estaRechazado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no puede ser solicitada en el estado actual.',
                ]);
            }
            $venta->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
            $venta->save();
        });
    }

}
