<?php

namespace App\Services;
use App\Services\ArticuloAlmacenService;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\Reclasificacion;
use App\Models\ReclasificacionArticulo;
use App\Enums\EstadoMovimientoAlmacen;
use Illuminate\Validation\ValidationException;


class ReclasificacionService
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
            $reclasificacion = new Reclasificacion();
            $reclasificacion->almacen_id = $request->almacen_id;
            $reclasificacion->fecha = $request->fecha;
            $reclasificacion->save();
            return $reclasificacion;
        });
    }

 

    public function eliminar($reclasificacion_id)
    {
        DB::transaction(function() use ($reclasificacion_id) {

            $reclasificacion = Reclasificacion::findOrFail($reclasificacion_id);
            
            if (!$reclasificacion->estaEnCaptura() && !$reclasificacion->estaRechazado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La reclasificación no puede ser eliminada en el estado actual.',
                ]);
            }
            $reclasificacion->delete();
          
        });
    }

    public function validar($reclasificacion_id)
    {
        DB::transaction(function() use ($reclasificacion_id) {

            $reclasificacion = Reclasificacion::findOrFail($reclasificacion_id);
            
            if (!$reclasificacion->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La reclasificación no está solicitada y no puede ser validada.',
                ]);
            }


            $reclasificacion->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $reclasificacion->save();
            $reclasificacion_articulos = ReclasificacionArticulo::where("reclasificacion_id", $reclasificacion->id)->get();

            foreach($reclasificacion_articulos as $reclasificacion_articulo)
            {
                if($reclasificacion_articulo->cantidad > 0)
                {
                    $this->articuloAlmacenService->descontar($reclasificacion_articulo->articulo_id, $reclasificacion->almacen_id, 0,  $reclasificacion_articulo->cantidad,$reclasificacion);
                    $this->articuloAlmacenService->agregar($reclasificacion_articulo->articulo_id, $reclasificacion->almacen_id, $reclasificacion_articulo->cantidad, 0, $reclasificacion);
                }

                if($reclasificacion_articulo->cantidad_defectuosos > 0)
                {
                    $this->articuloAlmacenService->descontar($reclasificacion_articulo->articulo_id, $reclasificacion->almacen_id, $reclasificacion_articulo->cantidad_defectuosos, 0,$reclasificacion);
                    $this->articuloAlmacenService->agregar($reclasificacion_articulo->articulo_id, $reclasificacion->almacen_id, 0, $reclasificacion_articulo->cantidad_defectuosos, $reclasificacion);
                }
            }
        });
    }

    public function cancelar($reclasificacion_id)
    {
        DB::transaction(function() use ($reclasificacion_id) {

            $reclasificacion = Reclasificacion::findOrFail($reclasificacion_id);
            
            if (!$reclasificacion->estaValidado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La reclasificación no está validada y no puede ser cancelada.',
                ]);
            }

            $reclasificacion->estado = EstadoMovimientoAlmacen::CANCELADO->value;
            $reclasificacion->save();
            $carga_articulos = CargaArticulo::where("carga_id", $reclasificacion->carga_id)->get();

            foreach($carga_articulos as $carga_articulo){
                $this->articuloAlmacenService->descontar($carga_articulo->articulo_id, $reclasificacion->almacen_id, $carga_articulo->cantidad, $carga_articulo->cantidad_defectuosos, $reclasificacion);
            }
        });
    }

    public function rechazar($reclasificacion_id)
    {
        $reclasificacion = Reclasificacion::findOrFail($reclasificacion_id);

        if (!$reclasificacion->estaSolicitado()) {
            throw ValidationException::withMessages([
                'estado' => 'La reclasificación no está solicitada y no puede ser rechazada.',
            ]);
        }
        
        $reclasificacion->estado = EstadoMovimientoAlmacen::RECHAZADO->value;
        $reclasificacion->save();
    }

    public function solicitar($reclasificacion_id)
    {
        $reclasificacion = Reclasificacion::findOrFail($reclasificacion_id);

        if (!$reclasificacion->estaEnCaptura()&& !$reclasificacion->estaRechazado() ) {
            throw ValidationException::withMessages([
                'estado' => 'La reclasificación no puede ser solicitada en este momento de la reclasificación',
            ]);
        }
        
        $reclasificacion->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
        $reclasificacion->save();
    }
     
}
