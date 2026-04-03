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
            
            //no debed ser anterior al dia de corte        
            if($venta['fecha']->isBefore(now()->subWeek())){
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
            
            if (!$venta->estaEnCaptura() && !$venta->estaRechazado() && !$venta->estaCancelado() ) {
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

            $venta = Venta::where('id', $venta_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$venta->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no puede ser validada en el estado actual.',
                ]);
            }

            $venta->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $venta->save();

            $venta_articulos = VentaArticulo::where("venta_id", $venta_id)->get();

            foreach ($venta_articulos as $venta_articulo) {

                $this->articuloAlmacenService->descontar(
                    $venta_articulo->articulo_id,
                    $venta->almacen_id,
                    $venta_articulo->cantidad,
                    $venta_articulo->cantidad_defectuosos,
                    $venta
                );


                //Solo descontar si esta el campo entregado_at
                //$venta_articulo->entregado_at = now();
                $venta_articulo->save();
            }

        });
    }

/*
    public function forzarValidacion(int $venta_id): void
    {
        DB::transaction(function() use ($venta_id) {

            $venta = Venta::where('id', $venta_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$venta->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no puede ser validada en el estado actual.',
                ]);
            }

            $venta->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $venta->save();

            $venta_articulos = VentaArticulo::where("venta_id", $venta_id)->get();

            foreach ($venta_articulos as $venta_articulo) {

                try {

                    $this->articuloAlmacenService->descontar(
                        $venta_articulo->articulo_id,
                        $venta->almacen_id,
                        $venta_articulo->cantidad,
                        $venta_articulo->cantidad_defectuosos,
                        $venta
                    );

                    // solo si se pudo descontar inventario
                    $venta_articulo->entregado_at = now();
                    $venta_articulo->save();

                } catch (\Throwable $e) {
                    // si no hay inventario simplemente no lo marcamos como entregado
                    // opcionalmente podrías registrar el error
                }
            }

        });
    }
*/

    public function obtenerErrores(int $venta_id)
    {
        $errores = [];
        $i=0;

        $venta = Venta::where('id', $venta_id)
            ->firstOrFail();
        
        if( $venta->total < $venta->total_real ){
            $errores[]=[ "id"=>$i++,
             "error"=>"El precio de venta es menor que el precio de lista"
            ];
        }

        $articulos = DB::table('venta_articulo as va')
            ->join('ventas as v', 'v.id', '=', 'va.venta_id')
            ->join('articulos as a', 'a.id', '=', 'va.articulo_id')
            ->join('tipo_articulos as ta', 'ta.id', '=', 'a.tipo_articulo_id')

            ->leftJoin('almacen_articulo as aa', function ($join) {
                $join->on('aa.articulo_id', '=', 'va.articulo_id')
                    ->on('aa.almacen_id', '=', 'v.almacen_id');
            })

            ->select(
                'va.articulo_id',
                'ta.nombre as articulo_nombre',

                'va.cantidad as venta_cantidad',
                'va.cantidad_defectuosos as venta_defectuosos',

                DB::raw('COALESCE(aa.cantidad, 0) as stock'),
                DB::raw('COALESCE(aa.cantidad_defectuosos, 0) as stock_defectuosos')
            )

            ->where('va.venta_id', $venta_id)
            ->get();

        $faltantes = $articulos->filter(function ($a) {
            return $a->venta_cantidad > $a->stock ||
                $a->venta_defectuosos > $a->stock_defectuosos;
        });

        foreach($faltantes as $faltante)
        {
            $error="En {$faltante->articulo_nombre} se tienen un stock de  {$faltante->stock} buenos y {$faltante->stock_defectuosos} defectuosos, se requieren";
            $error.=($faltante->venta_cantidad>0)?" {$faltante->venta_cantidad} buenos":"";
            $error.=($faltante->venta_defectuosos>0)?" {$faltante->venta_defectuosos} defectuosos":"";

        
            $errores[]=[
                "id"=>$i++,
                "error"=>$error
            ];

        }
        
        if(count($errores)==0 && $venta->estaEnCaptura()){
                $errores[]=[
            "id"=>1,
            "error"=>"La venta no tiene errores, pero aún está en captura, por favor solicítala para validarla"
            ];
        }

        return response()->json($errores);

    }

    
    public function cancelar(int $venta_id): void
    {
        DB::transaction(function () use ($venta_id) {

            $venta = Venta::where('id', $venta_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$venta->estaValidado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no puede ser cancelada en el estado actual.'
                ]);
            }

            $venta_articulos = VentaArticulo::where("venta_id", $venta_id)
                ->whereNotNull("entregado_at")
                ->get();

            foreach ($venta_articulos as $venta_articulo) {

                $this->articuloAlmacenService->agregar(
                    $venta_articulo->articulo_id,
                    $venta->almacen_id,
                    $venta_articulo->cantidad,
                    $venta_articulo->cantidad_defectuosos,
                    $venta
                );

                // limpiar marca de entrega
                $venta_articulo->entregado_at = null;
                $venta_articulo->save();
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
            if (!$venta->estaEnCaptura() && !$venta->estaRechazado()  && !$venta->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta no puede ser solicitada en el estado actual.',
                ]);
            }

            if ($venta->cantidad + $venta->cantidad_defectuosos <= 0) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta debe tener al menos un artículo.',
                ]);
            }
            $venta->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
            $venta->save();
        });

        $venta = Venta::findOrFail($venta_id);
        if( $venta->total < $venta->total_real )
        {
            throw ValidationException::withMessages([
                'estado' => 'El total de la venta es mas bajo que el precio de lista',
            ]);
        }

        $this->validar($venta_id);
    }

}
