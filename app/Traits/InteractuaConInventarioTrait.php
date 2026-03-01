<?php

namespace App\Traits;
use App\Models\Movimiento;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait InteractuaConInventarioTrait
{

    public function movimientos(): MorphMany
    {
        return $this->morphMany(Movimiento::class, 'movible');
    }

    public function crearMovimiento(array $data)
    {
        return $this->movimientos()->create($data);
    }
    
    public static function morph(): string
    {
        return (new static)->getMorphClass();
    }

}
