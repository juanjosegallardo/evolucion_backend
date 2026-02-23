<?php
namespace App\Contracts;

interface GeneraMovimientoAlmacen
{
    public function movimientos();
    public function estadoMovimiento(): string;
}