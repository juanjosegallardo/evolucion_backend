<?php

namespace App\Models;
use App\Models\TipoArticulo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use SoftDeletes;

    //
    protected $attributes = ["cantidad"=>0, "cantidad_defectuosos"=>0];

    public function tipoArticulo()
    {
        return $this->belongsTo(TipoArticulo::class);
    }
}
