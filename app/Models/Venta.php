<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vendedor;
use App\Models\Almacen;

class Venta extends Model
{
    use EstadoMovimientoAlmacenTrait;
    
    protected $attributes = ["cantidad"=>0];
    protected $dates = ["fecha"];
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'venta_articulo');
    }

    public function calcularComision(): void
    {
        if ($this->tipo === 'CREDITO') {

            $this->porcentaje = 10;
            $this->comision = ($this->porcentaje / 100) * $this->total;
            $this->a_pagar = $this->comision - $this->enganche;

        } elseif ($this->tipo === 'CONTADO') {

            $this->enganche = 0;
            $this->porcentaje = 0;
            $this->comision = 0;
            $this->a_pagar = 0;
        }
    }
}
