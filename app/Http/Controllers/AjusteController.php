<?php

namespace App\Http\Controllers;

use App\Models\Ajuste;
use App\Http\Requests\StoreAjusteRequest;
use App\Http\Requests\UpdateAjusteRequest;
use Illuminate\Http\Request;
use App\Services\AjusteService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AjusteController extends Controller
{
    use AuthorizesRequests;

    protected $ajusteService;

    public function __construct(AjusteService $ajusteService)
    {
        $this->ajusteService = $ajusteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Ajuste::visiblePara(auth()->user())
            ->with("almacen.responsable")
            ->with("articulos")
            ->orderBy("created_at", "desc")
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAjusteRequest $request)
    {
        $this->authorize("create", [Ajuste::class, $request]);

        $ajuste = $this->ajusteService->crear($request);
        return $this->show($ajuste->id);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Ajuste::with([
            "articulos" => function ($q) {
                $q->withPivot(["id", "cantidad", "cantidad_defectuosos"])
                  ->with("tipoArticulo")
                  ->orderByPivot("id", "desc");
            }
        ])
        ->with("almacen.responsable")
        ->findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ajuste = Ajuste::findOrFail($id);

        $this->authorize("delete", $ajuste);

        $this->ajusteService->eliminar($id);
    }

    public function solicitarValidacion($id)
    {
        $ajuste = Ajuste::findOrFail($id);

        $this->authorize("solicitar", $ajuste);

        $this->ajusteService->solicitar($id);

        return Ajuste::with("almacen")->find($id);
    }

    public function validar($id)
    {
        $ajuste = Ajuste::findOrFail($id);

        $this->authorize("validar", $ajuste);

        $this->ajusteService->validar($id);

        return Ajuste::with("almacen")->find($id);
    }

    public function cancelar($id)
    {
        $ajuste = Ajuste::findOrFail($id);

        $this->authorize("cancelar", $ajuste);

        $this->ajusteService->cancelar($id);

        return Ajuste::with("almacen")->find($id);
    }

    public function rechazar($id)
    {
        $ajuste = Ajuste::findOrFail($id);

        $this->authorize("rechazar", $ajuste);

        $this->ajusteService->rechazar($id);

        return Ajuste::with("almacen")->find($id);
    }
}