<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\MovimientoInventarioRegistry;

class Movimiento extends Model
{
    protected $fillable = [
        "articulo_id",
        "almacen_id",
        "user_id",
        "cantidad",
        "cantidad_defectuosos",
        "total_actual",
        "total_actual_defectuosos",
        "estado",
    ];
    
    public function movible()
    {
        return $this->morphTo();
    }


    public static function movibles()
    {
        return [
            Carga::class,
            Ajuste::class,
            Traspaso::class,
            Devolucion::class,
            Venta::class,
            Reclasificacion::class
        ];
    }


    public static function resolverClases($tipo)
    {
        $map = [
            'carga' => [
                \App\Models\CargaArticulo::class,
                \App\Models\Carga::class
            ],
            'ajuste' => [
                \App\Models\AjusteArticulo::class,
                \App\Models\Ajuste::class
            ],
            'traspaso' => [
                \App\Models\TraspasoArticulo::class,
                \App\Models\Traspaso::class
            ],
            'reclasificacion' => [
                \App\Models\ReclasificacionArticulo::class,
                \App\Models\Reclasificacion::class
            ],
            'venta' => [
                \App\Models\VentaArticulo::class,
                \App\Models\Venta::class
            ],
            'devolucion' => [
                \App\Models\DevolucionArticulo::class,
                \App\Models\Devolucion::class
            ],
        ];

        if (!isset($map[$tipo])) {
            throw new \Exception("Tipo no soportado");
        }

        return $map[$tipo];
    }

    public static function registrarTodos()
    {
        foreach (self::movibles() as $m) {
            MovimientoInventarioRegistry::register($m);
        }
    }
}
