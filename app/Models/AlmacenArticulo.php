<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlmacenArticulo extends Model
{
    protected $fillable = [
        "almacen_id",
        "articulo_id",
        "cantidad",
        "cantidad_defectuosos"
    ];
    protected $table = "almacen_articulo";

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }   

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
}
