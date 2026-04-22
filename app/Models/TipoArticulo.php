<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TipoArticulo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nombre',
        'precio_contado',
        'precio_credito'
    ];
    protected $table="tipo_articulos";

    
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'tipo_articulo_id');
    }
}
