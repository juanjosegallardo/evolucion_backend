<?php
namespace App\Contracts;

interface GeneraMovimientoAlmacen
{
    public function movimientos();
    public function estadoMovimiento(): string;
    public function crearMovimiento(array $data);
    public static function morph():string;
    public static function table():string;
}