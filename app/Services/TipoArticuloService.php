<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\TipoArticulo;
use Illuminate\Http\Request;


class TipoArticuloService
{
    public function actualizarPrecio($request, $id )
    {
        DB::transction(function() use ($request){
           
            $tipo_articulo =TipoArticulo::find($id);
            $tipo_articulo->precio_credito = $request->precio_contado;
            $tipo_articulo->precio_contado =  $tipo_articulo->precio_contado/2;
            $tipo_articulo->update();
        });
    }
}