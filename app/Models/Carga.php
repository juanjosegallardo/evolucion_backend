<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Traits\EstadoMovimientoAlmacenTrait;

class Carga extends Model
{
    use EstadoMovimientoAlmacenTrait;
    protected $attributes = ["cantidad"=>0];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'carga_articulo');
    }
}
