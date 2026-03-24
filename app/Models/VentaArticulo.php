<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaArticulo extends Model
{
    protected $table = "venta_articulo";
    protected $fillable = ["cantidad", "cantidad_defectuosos"];

    public function estaEntregado(): bool
    {
        return $this->entregado_at !== null;
    }
 
}
