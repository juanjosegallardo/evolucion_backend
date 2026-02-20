<?php

namespace App\Enums;

enum EstadoMovimientoAlmacen:string
{
    case EN_CAPTURA = 'EN_CAPTURA';
    case SOLICITADO = 'SOLICITADO';
    case VALIDADO = 'VALIDADO';
    case RECHAZADO = 'RECHAZADO';
    case CANCELADO = 'CANCELADO';
}
