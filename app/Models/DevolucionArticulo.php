<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevolucionArticulo extends Model
{
    protected $table = "devolucion_articulo";
    protected $fillable = ["cantidad", "cantidad_defectuosos"];
}
