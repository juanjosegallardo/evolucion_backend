<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovibleArticuloService;
use App\Models\Movimiento;

class MovibleArticuloController extends Controller
{
    protected $service;

    public function __construct(MovibleArticuloService $service)
    {
        $this->service = $service;
    }



    public function store(Request $request, $tipo, $id)
    {
        [$pivotClass, $movibleClass] = Movimiento::resolverClases($tipo);

        return $this->service->guardar(
            $pivotClass,
            $movibleClass, 
            $id, 
            $request
        );
   
    }

    public function update(Request $request, $tipo, $id)
    {
        [$pivotClass, $movibleClass] = Movimiento::resolverClases($tipo);

        return $this->service->editar(
            $pivotClass,
            $movibleClass,
            $request,
            $id
        );
        
        return $this->service->obtenerArticulos(movibleClass::class, $id); 
    }

    public function destroy($tipo, $id)
    {   

        [$pivotClass, $movibleClass] = Movimiento::resolverClases($tipo);
    


        return $this->service->eliminar(
            $pivotClass,
            $movibleClass,
            $id
        );

    }


    

   
}