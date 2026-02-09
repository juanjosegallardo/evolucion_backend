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
            $venta->porcentaje = 10;
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
