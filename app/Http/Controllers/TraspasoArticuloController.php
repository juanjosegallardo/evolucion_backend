<?php

namespace App\Http\Controllers;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Traspaso;
use App\Models\TraspasoArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\TraspasoArticuloService;

class TraspasoArticuloController extends Controller
{
    public function __construct(TraspasoArticuloService $traspasoArticuloService)
    {
        $this->traspasoArticuloService = $traspasoArticuloService;
    }   

    public function store(Request $request, $id)
    {  
        $this->traspasoArticuloService->guardar($request, $id);
        
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($id);
    }

    public function destroy( $id)
    {
        
        $this->traspasoArticuloService->eliminar($id);
        
        return Traspaso::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo");
        }])->find($id);
    }


}
