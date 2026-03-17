<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AjusteArticulo extends Model
{
    protected $table ="ajuste_articulo";

    protected $fillable = [
        "almacen_id",
        "articulo_id",
        "cantidad",
        "cantidad_defectuosos"
    ];
}
