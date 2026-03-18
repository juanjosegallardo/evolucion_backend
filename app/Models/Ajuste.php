<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\GeneraMovimientoAlmacen;
use App\Models\ModelMovimientoAlmacen;


class Ajuste extends ModelMovimientoAlmacen implements GeneraMovimientoAlmacen
{

    protected $attributes = ["cantidad"=>0];
    protected $dates = ["fecha"];
    protected $fillable = ["cantidad", "cantidad_defectuosos"];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'ajuste_articulo');
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
