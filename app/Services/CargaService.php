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

    public function eliminar($carga_id)
    {
        DB::transaction(function() use ($carga_id) {

            $carga = Carga::findOrFail($carga_id);
            
            if (!$carga->estaEnCaptura() && !$carga->estaRechazado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La carga no puede ser eliminada en el estado actual.',
                ]);
            }
            $carga->delete();
          
        });
    }

    public function validar($carga_id)
    {
        DB::transaction(function() use ($carga_id) {

            $carga = Carga::findOrFail($carga_id);
            
            if (!$carga->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La carga no está solicitada y no puede ser validada.',
                ]);
            }
            
            $carga->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $carga->save();
            $carga_articulos = CargaArticulo::where("carga_id", $carga_id)->get();

            foreach($carga_articulos as $carga_articulo){
                $this->articuloAlmacenService->agregar($carga_articulo->articulo_id, $carga->almacen_id, $carga_articulo->cantidad, $carga_articulo->cantidad_defectuosos);
            }
        });
    }

    public function rechazar($carga_id)
    {
        $carga = Carga::findOrFail($carga_id);

        if (!$carga->estaSolicitado()) {
            throw ValidationException::withMessages([
                'estado' => 'La carga no está solicitada y no puede ser rechazada.',
            ]);
        }
        
        $carga->estado = EstadoMovimientoAlmacen::RECHAZADO->value;
        $carga->save();
    }

    public function solicitar($carga_id)
    {
        $carga = Carga::findOrFail($carga_id);

        if (!$carga->estaEnCaptura()&& !$carga->estaRechazado() ) {
            throw ValidationException::withMessages([
                'estado' => 'La carga no puede ser solicitada en este momento de la carga',
            ]);
        }
        
        $carga->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
        $carga->save();
    }
     
}
