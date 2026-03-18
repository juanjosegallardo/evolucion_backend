<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ajuste;
use App\Models\AjusteArticulo;
use App\Services\AjusteArticuloService;
use App\Services\AjusteService;

class AjusteArticuloController extends Controller
{
    protected $ajusteArticuloService;
    protected $ajusteService;

    public function __construct(AjusteService $ajusteService, AjusteArticuloService $ajusteArticuloService)
    {
        $this->ajusteArticuloService = $ajusteArticuloService;
        $this->ajusteService = $ajusteService;
        
    }

    public function store(Request $request, $id)
    {

    }

    public function update(Request $request, $id)
    {
        $this->ajusteArticuloService->editar($request, $id);

        $ajuste_articulo = AjusteArticulo::find($id);


        return $this->ajusteService->show($ajuste_articulo->ajuste_id);
    }

    public function destroy($id)
    {

    }
}