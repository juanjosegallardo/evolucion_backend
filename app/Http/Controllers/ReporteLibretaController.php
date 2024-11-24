<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use App\Models\Vendedor;
use Illuminate\Http\Request;

class ReporteLibretaController extends Controller
{
    public function reporteVendedores($id)
    {
        $data["ventas"]=  Venta::with("vendedor")->with(["articulos"=>function($q){
            $q->with("tipoArticulo")->withPivot("cantidad");
        }])->where("vendedor_id","=",$id)->get();

        $data["vendedor"]= Vendedor::find($id);
        //return $data;
        return view("libreta", $data);
    }
}
