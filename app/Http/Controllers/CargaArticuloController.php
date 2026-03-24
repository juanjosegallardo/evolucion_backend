<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Carga;
use App\Models\CargaArticulo;
use Illuminate\Support\Facades\DB;
use App\Services\CargaArticuloService;


class CargaArticuloController extends Controller
{

    public function __construct(MovibleArticuloService $movibleArticulo)
    {
        $this->movibleArticulo = $movibleArticulo;
    }


    public function store($movibleClass, $id, $request)
    {
        $this->service->guardar($movibleClass, $id, $request);
        return  $this->movibleArticulo->obtenerArticulos($movibleClass, $id);
    }


    public function destroy( $id)
    {   
        $carga_articulo = CargaArticulo::find($id);
        $this->cargaArticuloService->eliminar(
            CargaArticulo::class,
            $id
        );
        return $this->movibleArticulo->obtenerArticulos(Carga::class, $id); 
    }

    public function update(Request $request, $id)
    {
        $this->cargaArticuloService->editar(
            CargaArticulo::class,
            Carga::class,
            $request,
            $id
        );

        return   $this->movibleArticulo->obtenerArticulos(Carga::class, $id);
    }
}
