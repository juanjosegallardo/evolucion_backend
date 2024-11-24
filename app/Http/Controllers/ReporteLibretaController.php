<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use Illuminate\Http\Request;

class ReporteLibretaController extends Controller
{
    public function reporteVendedores($id)
    {
        $data["ventas"]=  Venta::with("vendedor")->with(["articulos"=>function($q){
            $q->with("tipoArticulo");
        }])->where("vendedor_id","=",$id)->get();
        return $data;
        //return view("libreta", $data);
    }
}
