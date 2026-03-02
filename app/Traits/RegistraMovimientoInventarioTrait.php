<?php

namespace App\Traits;
use App\Support\MovimientoInventarioRegistry;


trait RegistraMovimientoInventarioTrait
{
    public static function bootRegistraMovimientoInventarioTrait()
    {
        
        $class = static::class;
        if (!in_array($class, MovimientoInventarioRegistry::all())) {
            MovimientoInventarioRegistry::register($class);
        }
    
  
    }
}
