<?php

namespace App\Http\Controllers;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function kardex($almacen_id, $articulo_id )
    {   
        return Movimiento::where('almacen_id', $almacen_id)
            ->where("articulo_id",$articulo_id)
            ->latest()
            ->take(50)
            ->get();
    }
}
