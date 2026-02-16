<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EstadoMovimientoAlmacenTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devolucion extends Model
{
    use EstadoMovimientoAlmacenTrait;
    use SoftDeletes;

    protected $attributes = ["cantidad"=>0];
    protected $table = "devoluciones";

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'usuario_vendedor_id');
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
