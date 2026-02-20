<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use App\Http\Requests\StoreCargaRequest;
use App\Http\Requests\UpdateCargaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CargaService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CargaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    protected $cargaService;

    public function __construct(CargaService $cargaService)
    {
        $this->cargaService = $cargaService;
    }   
    
    public function index()
    {
        return Carga::visiblePara(auth()->user())->with("almacen")->with("articulos")->orderBy("created_at", "desc")->get();
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
        $carga = new Carga();
        $carga->almacen_id = $request->almacen_id;
        $carga->notas = $request->notas;
        $carga->save();
        return Carga::with("almacen")->find($carga->id);//hay que regresar with articulos

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Carga::with(["articulos"=>function($q){
            $q->withPivot(["id","cantidad", "cantidad_defectuosos"])->with("tipoArticulo")->orderByPivot("id","desc");
        }])->with("almacen")->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carga $carga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargaRequest $request, Carga $carga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $carga = Carga::findOrFail($id);
        $this->authorize("destroy",$carga); 
        $this->cargaService->eliminar($id);
    }


    public function solicitarValidacion($id)
    {
        $carga = Carga::findOrFail($id);
        $this->authorize("solicitar",$carga);
        $this->cargaService->solicitar($id);
        return Carga::with("almacen")->find($id);
    }

    public function validar($id)
    {
        $carga = Carga::findOrFail($id);
        $this->authorize("validar",$carga);
        $this->cargaService->validar($id);
        return Carga::with("almacen")->find($id);
    }

    public function cancelar($id)
    {
        $carga = Carga::findOrFail($id);
        $this->authorize("cancelar",$carga);
        $this->cargaService->cancelar($id);
        return Carga::with("almacen")->find($id);
    }

    public function rechazar($id)
    {
        $carga = Carga::findOrFail($id);
        $this->authorize("rechazar",$carga);
        $this->cargaService->rechazar($id);
        return Carga::with("almacen")->find($id);
    }

}
