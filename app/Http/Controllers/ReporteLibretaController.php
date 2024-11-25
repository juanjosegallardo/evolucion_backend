<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use PDF;

class ReporteLibretaController extends Controller
{
    public function reporteVendedores($id)
    {
        $data["ventas"]=  Venta::with("vendedor")->with(["articulos"=>function($q){
            $q->with("tipoArticulo")->withPivot("cantidad");
        }])->where("vendedor_id","=",$id)->orderBy("fecha","asc")->get();

        $data["vendedor"]= Vendedor::find($id);
        $pdf = PDF::loadView("libreta", $data);
        return $pdf->stream("libreta.pdf");
        //return $pdf->download("libreta.pdf");
        //return $data;
        //return view("libreta", $data);
    }
}
