<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use Illuminate\Http\Request;

class ReporteLibretaController extends Controller
{
    public function reporteVendedores($id)
    {
        $data["ventas"]=  Venta::with("vendedor")->with(["articulo"=>function($q){
            $q->with("tipo_archivo");
        }])->get();
        //return $data;
         return view("libreta", $data);
    }
}
