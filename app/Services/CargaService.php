<?php

namespace App\Services;
use App\Services\ArticuloAlmacenService;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\Carga;
use App\Models\CargaArticulo;

class CargaService
{
    /**
     * Create a new class instance.
     */

    protected $articuloAlmacenService;
    public function __construct(ArticuloAlmacenService $articuloAlmacenService)
    {
        $this->articuloAlmacenService = $articuloAlmacenService;
    }   

    public function validarCarga($carga_id)
    {
        DB::transaction(function() use ($carga_id) {

            $carga = Carga::findOrFail($carga_id);
            $carga->estado = 'VALIDADO';
            $carga->save();
            $carga_articulos = CargaArticulo::where("carga_id", $carga_id)->get();
            \Log::info($carga_articulos->toArray());
            foreach($carga_articulos as $carga_articulo){
                $this->articuloAlmacenService->agregar($carga_articulo->articulo_id, $carga->almacen_id, $carga_articulo->cantidad, $carga_articulo->cantidad_defectuosos);
            }
        });
    }
     
}
