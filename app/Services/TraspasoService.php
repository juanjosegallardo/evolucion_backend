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
use Illuminate\Http\Request;

class TraspasoService
{
    /**
     * Create a new class instance.
     */

    protected $articuloAlmacenService;
    

    public function create (Request $request)
    {
        return DB::transaction(function() use ($request) {
            $traspaso = new Traspaso();
            $traspaso->almacen_origen_id = $request->almacen_origen_id;
            $traspaso->almacen_destino_id = $request->almacen_destino_id;
            $traspaso->fecha = $request->fecha;
            $traspaso->save();
            return $traspaso;
        });
    }

    public function __construct(ArticuloAlmacenService $articuloAlmacenService)
    {
        $this->articuloAlmacenService = $articuloAlmacenService;
    }   


    public function eliminar($traspaso_id)
    {
        DB::transaction(function() use ($traspaso_id) {

            $traspaso = Traspaso::findOrFail($traspaso_id);
            
            if (!$traspaso->estaEnCaptura()&& !$traspaso->estaRechazado()) {
                throw ValidationException::withMessages([
                    'estado' => 'El traspaso no puede ser eliminado en el estado actual',
                ]);
            }

            $traspaso->delete();
          
        });
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
                $this->articuloAlmacenService->agregar($traspaso_articulo->articulo_id, $traspaso->almacen_destino_id, $traspaso_articulo->cantidad, $traspaso_articulo->cantidad_defectuosos, $traspaso);
                $this->articuloAlmacenService->descontar($traspaso_articulo->articulo_id, $traspaso->almacen_origen_id, $traspaso_articulo->cantidad, $traspaso_articulo->cantidad_defectuosos, $traspaso);
            }
        });
    }


    
    public function cancelar($traspaso_id)
    {
        DB::transaction(function() use ($traspaso_id) {

            $traspaso = Traspaso::findOrFail($traspaso_id);
            
            if (!$traspaso->estaValidado()) {
                throw ValidationException::withMessages([
                    'estado' => 'El traspaso no está validado y no puede ser cancelado.',
                ]);
            }
            
            $traspaso->estado = EstadoMovimientoAlmacen::CANCELADO->value;
            $traspaso->save();
            $traspaso_articulos = TraspasoArticulo::where("traspaso_id", $traspaso_id)->get();

            foreach($traspaso_articulos as $traspaso_articulo){
                $this->articuloAlmacenService->agregar($traspaso_articulo->articulo_id, $traspaso->almacen_origen_id, $traspaso_articulo->cantidad, $traspaso_articulo->cantidad_defectuosos, $traspaso);
                $this->articuloAlmacenService->descontar($traspaso_articulo->articulo_id, $traspaso->almacen_destino_id, $traspaso_articulo->cantidad, $traspaso_articulo->cantidad_defectuosos, $traspaso);
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

            if (!$traspaso->estaEnCaptura() && !$traspaso->estaRechazado()) {
                throw ValidationException::withMessages([
                    'estado' => 'El traspaso no puede ser solicitado en este momento',
                ]);
            }
            
            $traspaso->estado = EstadoMovimientoAlmacen::SOLICITADO->value;
            $traspaso->save();  
        });
    }
}
