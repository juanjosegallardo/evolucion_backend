<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ajuste;
use App\Models\AjusteArticulo;
use App\Services\AjusteArticuloService;

class AjusteArticuloController extends Controller
{
    protected $ajusteArticuloService;

    public function __construct(AjusteArticuloService $ajusteArticuloService)
    {
        $this->ajusteArticuloService = $ajusteArticuloService;
    }

    public function store(Request $request, $id)
    {
        $this->ajusteArticuloService->guardar($request, $id);


        
        return Ajuste::with([
            "articulos" => function ($q) {
                $q->withPivot(["id", "cantidad", "cantidad_defectuosos"])
                  ->with("tipoArticulo")
                  ->orderByPivot("id", "desc");
            }
        ])->find($id);
    }

    public function update(Request $request, $id)
    {
        $this->ajusteArticuloService->editar($request, $id);

        $ajuste_articulo = AjusteArticulo::find($id);

        return Ajuste::with([
            "articulos" => function ($q) {
                $q->withPivot(["id", "cantidad", "cantidad_defectuosos"])
                  ->with("tipoArticulo")
                  ->orderByPivot("id", "desc");
            }
        ])->find($ajuste_articulo->ajuste_id);
    }

    public function destroy($id)
    {
        $ajuste_articulo = AjusteArticulo::find($id);

        $this->ajusteArticuloService->eliminar($id);

        return Ajuste::with([
            "articulos" => function ($q) {
                $q->withPivot(["id", "cantidad", "cantidad_defectuosos"])
                  ->with("tipoArticulo")
                  ->orderByPivot("id", "desc");
            }
        ])->find($ajuste_articulo->ajuste_id);
    }
}