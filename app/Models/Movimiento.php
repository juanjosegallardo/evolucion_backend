<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
    
    public function movible()
    {
        return $this->morphTo();
    }
}
