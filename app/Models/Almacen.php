<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Almacen extends Model
{
    
    use SoftDeletes;
    protected $table="almacenes";
    protected $attributes = ["cantidad"=>0];
    
    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'almacen_articulo');
    }
    
}
