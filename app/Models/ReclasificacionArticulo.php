<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReclasificacionArticulo extends Model
{
    protected $table = "reclasificacion_articulo";
    protected $fillable = ["cantidad", "cantidad_defectuosos"];
}
