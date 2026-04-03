<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\TipoArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TipoArticuloService
{
    public function actualizar(array $data, $id )
    {
        DB::transaction(function() use ($data, $id){
           
            $tipo_articulo =TipoArticulo::find($id);
            $tipo_articulo->nombre = Str::upper($data["nombre"]);
            $tipo_articulo->precio_credito = $data["precio_credito"];
            $tipo_articulo->precio_contado = $data["precio_contado"];
            $tipo_articulo->update();
        });
    }

    public function guardar(array $data )
    {
        DB::transaction(function() use ($data){
           
            $tipo_articulo = new TipoArticulo();
            $tipo_articulo->fill($data);
            $tipo_articulo->nombre = Str::upper($data["nombre"]);
            $tipo_articulo->save();


            $articulo = new Articulo();
            $articulo->nombre = "*";
            $articulo->codigo = Str::upper(Str::random(10));
            $articulo->tipo_articulo_id = $tipo_articulo->id;
            $articulo->save();

        });
    }
}