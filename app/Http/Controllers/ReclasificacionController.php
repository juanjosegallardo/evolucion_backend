<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reclasificacion;
use App\Http\Requests\StoreReclasificacionRequest;
use App\Http\Requests\UpdateReclasificacionRequest;
use Illuminate\Support\Facades\DB;
use App\Services\ReclasificacionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ReclasificacionController extends Controller
{
 use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    protected $reclasificacionService;

    public function __construct(ReclasificacionService $reclasificacionService)
    {
        $this->reclasificacionService = $reclasificacionService;
    }   
    
    public function index()
    {
        return Reclasificacion::visiblePara(auth()->user())->with("almacen.responsable")->with("articulos")->orderBy("created_at", "desc")->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize("create",[Reclasificacion::class, $request]);
        $reclasificacion = $this->reclasificacionService->crear($request);
        return Reclasificacion::with("almacen.responsable")->with("articulos")->find($reclasificacion->id);//hay que regresar with articulos

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Reclasificacion::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo")->orderByPivot("id","desc");
        }])->with("almacen.responsable")->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reclasificacion $reclasificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReclasificacionRequest $request, Reclasificacion $reclasificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reclasificacion = Reclasificacion::findOrFail($id);
        $this->authorize("delete",$reclasificacion); 
        $this->reclasificacionService->eliminar($id);
    }


    public function solicitarValidacion($id)
    {
        $reclasificacion = Reclasificacion::findOrFail($id);
        $this->authorize("solicitar",$reclasificacion);
        $this->reclasificacionService->solicitar($id);
        return Reclasificacion::with("almacen")->find($id);
    }

    public function validar($id)
    {
        $reclasificacion = Reclasificacion::findOrFail($id);
        $this->authorize("validar",$reclasificacion);
        $this->reclasificacionService->validar($id);
        return Reclasificacion::with("almacen")->find($id);
    }

    public function cancelar($id)
    {
        $reclasificacion = Reclasificacion::findOrFail($id);
        $this->authorize("cancelar",$reclasificacion);
        $this->reclasificacionService->cancelar($id);
        return Reclasificacion::with("almacen")->find($id);
    }

    public function rechazar($id)
    {
        $reclasificacion = Reclasificacion::findOrFail($id);
        $this->authorize("rechazar",$reclasificacion);
        $this->reclasificacionService->rechazar($id);
        return Reclasificacion::with("almacen")->find($id);
    }
}
