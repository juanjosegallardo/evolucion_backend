<?php
namespace App\Services;
use App\Services\ArticuloAlmacenService;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\Traspaso;
use App\Models\TraspasoArticulo;
use App\Enums\EstadoMovimientoAlmacen;
use Illuminate\Validation\ValidationException;


class TraspasoService
{
    /**
     * Create a new class instance.
     */

    protected $articuloAlmacenService;
    
    public function __construct(ArticuloAlmacenService $articuloAlmacenService)
    {
        $this->articuloAlmacenService = $articuloAlmacenService;
    }   


    public function validar($traspaso_id)
    {
        DB::transaction(function() use ($traspaso_id) {

            $traspaso = Traspaso::findOrFail($traspaso_id);
            
            if (!$traspaso->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'El traspaso no está solicitado y no puede ser validado.',
                ]);
            }
            
            $traspaso->estado = EstadoMovimientoAlmacen::VALIDADO->value;
            $traspaso->save();
            $traspaso_articulos = TraspasoArticulo::where("traspaso_id", $traspaso_id)->get();

            foreach($traspaso_articulos as $traspaso_articulo){
                $this->articuloAlmacenService->agregar($traspaso_articulo->articulo_id, $traspaso->almacen_destino_id, $traspaso_articulo->cantidad, $traspaso_articulo->cantidad_defectuosos);
                $this->articuloAlmacenService->descontar($traspaso_articulo->articulo_id, $traspaso->almacen_origen_id, $traspaso_articulo->cantidad, $traspaso_articulo->cantidad_defectuosos);
            }
        });
    }

    public function rechazar($traspaso_id)
    {
        DB::transaction(function() use ($traspaso_id) {
            $traspaso = Traspaso::findOrFail($traspaso_id);

            if (!$traspaso->estaSolicitado()) {
                throw ValidationException::withMessages([
                    'estado' => 'El traspaso no está solicitado y no puede ser rechazado.',
                ]);
            }
            
            $traspaso->estado = EstadoMovimientoAlmacen::RECHAZADO->value;
            $traspaso->save(); 
        });
    }

    public function solicitar($traspaso_id)
    {
        DB::transaction(function() use ($traspaso_id) {
            $traspaso = Traspaso::findOrFail($traspaso_id);

            if (!$traspaso->estaEnCaptura()) {
                throw ValidationException::withMessages([
                    'estado' => 'El traspaso no está en captura y no puede ser solicitado.',
                ]);
            }
            
            $traspaso->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
            $traspaso->save();  
        });
    }
}
