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

    public static function registrarTodos()
    {
        foreach (self::movibles() as $m) {
            MovimientoInventarioRegistry::register($m);
        }
    }
}
