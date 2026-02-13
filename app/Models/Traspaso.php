<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EstadoMovimientoAlmacenTrait;


class Traspaso extends Model
{
    use EstadoMovimientoAlmacenTrait;

    protected $attributes = ["cantidad"=>0];
    public function origen()
    {
        return $this->belongsTo(Almacen::class, "almacen_origen_id");
    }
    
    public function destino()
    {
        return $this->belongsTo(Almacen::class, "almacen_destino_id");
    }
    
    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'traspaso_articulo');
    }

    
}
