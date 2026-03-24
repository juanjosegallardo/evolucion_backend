<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargaArticulo extends Model
{
    protected $table = "carga_articulo";
    protected $fillable = ["cantidad", "cantidad_defectuosos"];
}
