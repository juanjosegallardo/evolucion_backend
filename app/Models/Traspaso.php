<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\GeneraMovimientoAlmacen;
use App\Models\ModelMovimientoAlmacen;

class Traspaso extends ModelMovimientoAlmacen implements GeneraMovimientoAlmacen
{
    protected $dates = ["fecha"];
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

    public function scopeVisiblePara($query, User $user)
    {
        if ($user->esAdmin()) {
            return $query;
        }
        return $query->whereHas('origen', function ($q) use ($user) {
            $q->where('user_responsable_id', $user->id);
        })->orWhereHas('destino', function ($q) use ($user) {
            $q->where('user_responsable_id', $user->id);
        });
    }

}
