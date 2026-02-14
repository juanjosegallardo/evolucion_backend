<?php

namespace App\Traits;
use App\Enums\EstadoMovimientoAlmacen;

trait EstadoMovimientoAlmacenTrait
{
    public function estaEnCaptura(): bool
    {
        return $this->estado === EstadoMovimientoAlmacen::EN_CAPTURA->value ;
    }

    public function estaValidado(): bool
    {
        return $this->estado === EstadoMovimientoAlmacen::VALIDADO->value ;
    }   

    public function estaRechazado(): bool
    {
        return $this->estado === EstadoMovimientoAlmacen::RECHAZADO->value ;
    }  
        
    public function estaSolicitado(): bool
    {
        return $this->estado === EstadoMovimientoAlmacen::SOLICITADO->value ;
    }

    
}
