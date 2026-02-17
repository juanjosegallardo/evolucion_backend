<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Almacen;
use App\Traits\EstadoMovimientoAlmacenTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class Venta extends Model
{
    use EstadoMovimientoAlmacenTrait;

    protected $attributes = ["cantidad"=>0];
    protected $dates = ["fecha"];
    protected $fillable = ["total_real"];
    use SoftDeletes;

    public function actualizarTotalReal()
    {
        $total = $this->articulos()
            ->join('tipo_articulos', 'articulos.tipo_articulo_id', '=', 'tipo_articulos.id')
            ->selectRaw('SUM((venta_articulo.cantidad + venta_articulo.cantidad_defectuosos) * tipo_articulos.precio_credito) as total')
            ->value('total') ?? 0;

        $this->updateQuietly([
            'total_real' => $total
        ]);
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'user_vendedor_id');
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
