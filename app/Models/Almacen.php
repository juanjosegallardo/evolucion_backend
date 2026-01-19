<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    
    protected $table="almacenes";
    protected $attributes = ["cantidad"=>0];
    
    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'almacen_articulo');
    }
    
}
