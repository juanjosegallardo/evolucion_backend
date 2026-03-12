<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EstadoMovimientoAlmacenTrait;
use App\Traits\InteractuaConInventarioTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\GeneraMovimientoAlmacen;
use App\Traits\MetadatosClaseTrait;
use App\Traits\RegistraMovimientoInventarioTrait;

class Ajuste extends Model
{
    use EstadoMovimientoAlmacenTrait;
    use InteractuaConInventarioTrait;
    use RegistraMovimientoInventarioTrait;
    use MetadatosClaseTrait;
    use SoftDeletes;

    protected $attributes = ["cantidad"=>0];
    protected $dates = ["fecha"];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'reclasificacion_articulo');
    }

    public function scopeVisiblePara($query, User $user)
    {
        if ($user->esAdmin()) {
            return $query;
        }

        return $query->whereHas('almacen', function ($q) use ($user) {
            $q->where('user_responsable_id', $user->id);
        });
    }

}
