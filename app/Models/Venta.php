<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vendedor;
use App\Models\Almacen;

class Venta extends Model
{
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
}
