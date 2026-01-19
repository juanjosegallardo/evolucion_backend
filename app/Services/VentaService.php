<?php

namespace App\Services;
use App\Models\Venta;


class VentaService
{
    /**
     * Create a new class instance.
     */

    public function __construct()
    {
        //
    }

    public function calcularComision(Venta $venta)
    {
        if($venta->tipo=="CREDITO")
        {
            $porcentaje_enganche=($venta->enganche/  $venta->total) *100;
            if($porcentaje_enganche < 5)
            {
                $venta->porcentaje= 7;
            }
            else if( $porcentaje_enganche <10)
            {
                $venta->porcentaje = 12;
            }
            else
            {
                $venta->porcentaje = 14;
            }
            $venta->comision = ($venta->porcentaje/100)*$venta->total;
            $venta->a_pagar = $venta->comision-$venta->enganche;
        }
        if($venta->tipo=="CONTADO")
        {
            $venta->enganche = 0;
            $venta->porcentaje=0;
            $venta->comision =0;
            $venta->a_pagar = 0;
        }

    }

}
