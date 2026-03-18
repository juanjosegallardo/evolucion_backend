<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EstadoMovimientoAlmacenTrait;
use App\Traits\InteractuaConInventarioTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\MetadatosClaseTrait;
use App\Traits\RegistraMovimientoInventarioTrait;

class ModelMovimientoAlmacen extends Model
{
    use EstadoMovimientoAlmacenTrait;
    use InteractuaConInventarioTrait;
    use RegistraMovimientoInventarioTrait;
    use MetadatosClaseTrait;
    use SoftDeletes;
}
