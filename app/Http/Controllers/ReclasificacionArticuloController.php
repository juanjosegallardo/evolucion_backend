<?php

namespace App\Http\Controllers;
use App\Models\Reclasificacion;
use App\Services\ReclasificacionArticuloService;

use Illuminate\Http\Request;

class ReclasificacionArticuloController extends Controller
{
     public function __construct(ReclasificacionArticuloService $reclasificacionArticuloService)
    {
        $this->reclasificacionArticuloService = $reclasificacionArticuloService;
    }


    public function store(Request $request, $id)
    {
        $this->reclasificacionArticuloService->guardar($request, $id);
        
        return Reclasificacion::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo")->orderByPivot("id","desc");
        }])->find($id);
    }

    public function destroy( $id)
    {   
        $reclasificacion_articulo = ReclasificacionArticulo::find($id);
        $this->reclasificacionArticuloService->eliminar($id);
        return Reclasificacion::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo")->orderByPivot("id","desc");
        }])->find($reclasificacion_articulo->reclasificacion_id);
    }
}
