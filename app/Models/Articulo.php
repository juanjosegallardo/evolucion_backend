<?php

namespace App\Models;
use App\Models\TipoArticulo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Articulo extends Model
{
    use SoftDeletes;

    //
    protected $attributes = ["cantidad"=>0, "cantidad_defectuosos"=>0];

    public function tipoArticulo()
    {
        return $this->belongsTo(TipoArticulo::class);
    }

    public function scopeConExistenciaEn(\Illuminate\Database\Eloquent\Builder $query, $almacenId)
    {
        return $query
            ->select(
                'articulos.*',
                DB::raw('COALESCE(pivot.cantidad, 0) as cantidad'),
                DB::raw('COALESCE(pivot.cantidad_defectuosos, 0) as cantidad_defectuosos')
            )
            ->leftJoin('almacen_articulo as pivot', function ($join) use ($almacenId) {
                $join->on('articulos.id', '=', 'pivot.articulo_id')
                    ->where('pivot.almacen_id', $almacenId);
            });
    }
}
