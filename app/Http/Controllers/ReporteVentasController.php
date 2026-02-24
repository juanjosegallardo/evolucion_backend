<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\User;
use PDF;


class ReporteVentasController extends Controller
{
     public function reporteVendedores($id, Request $request)
    {
        $data["ventas"]=  Venta::with("vendedor")->with(["articulos"=>function($q){
            $q->with("tipoArticulo")->withPivot("cantidad");
        }])
        ->where("user_vendedor_id","=",$id)
        ->where("estado","=","VALIDADO")
        ->whereBetween("fecha", [$request->fecha_inicio, $request->fecha_fin])
        ->orderBy("fecha","asc")->get();

        $data["vendedor"]= User::find($id);
        $pdf = PDF::loadView("libreta", $data);
        return $pdf->stream("libreta.pdf");

    }
}
