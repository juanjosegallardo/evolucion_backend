<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use EstadoMovimientoAlmacenTrait;

    protected $attributes = ["cantidad"=>0];
    protected $table = "devoluciones";

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'venta_articulo');
    }

}
