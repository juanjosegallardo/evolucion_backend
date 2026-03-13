<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\AlmacenArticulo;
use App\Models\Movimiento;
use Carbon\Carbon;
use App\Models\Venta;
use App\Models\Carga;
use App\Models\Reclasificacion;
use App\Models\Traspaso;
use App\Models\Devolucion;
use App\Models\Ajuste;
use Illuminate\Support\Facades\DB;

class ReporteInventarioController extends Controller
{

    public function agregarMovimiento(
        string $tipoMovimiento,
        $fecha_inicio,
        $fecha_fin,
        $almacen_id
    ) {

        $tabla = $tipoMovimiento::table();
        $morph = $tipoMovimiento::morph();

        return Movimiento::query()
            ->selectRaw("
                movimientos.articulo_id,
                DAYOFWEEK({$tabla}.fecha) as dia_semana,
                SUM(COALESCE(movimientos.cantidad,0)) as cantidad,
                SUM(COALESCE(movimientos.cantidad_defectuosos,0)) as cantidad_defectuosos
            ")
            ->join($tabla, function ($join) use ($tabla, $morph) {
                $join->on("{$tabla}.id", '=', 'movimientos.movible_id')
                    ->where('movimientos.movible_type', $morph);
            })
            ->where('movimientos.almacen_id', $almacen_id)
            ->whereBetween("{$tabla}.fecha", [$fecha_inicio, $fecha_fin])
            ->groupBy('movimientos.articulo_id', 'dia_semana')
            ->get()
            ->groupBy('articulo_id')
            ->map(fn ($items) => $items->keyBy('dia_semana'))
            ->toArray();
    }

    public function reporteInventario($id, Request $request)
    {   
        $fecha_fin = Carbon::parse($request->fecha_fin)->endOfDay();
        $fecha_inicio = $fecha_fin->copy()->subDays(6)->startOfDay();
        
        $data["fecha"] = "{$fecha_inicio} - {$fecha_fin}";
        $data["articulos"] = AlmacenArticulo::with([
        
        "articulo.tipoArticulo"
        ])
        ->where("almacen_id",$id)
        ->get()
        ->sortBy('articulo.tipoArticulo.nombre')
        ->values();

        $data["inicial"] = Movimiento::query()
        ->select([
            'articulo_id',
            'total_actual',
            'total_actual_defectuosos'
        ])
        ->whereIn(
            'id',
            Movimiento::query()
                ->selectRaw('MAX(id)')
                ->where('almacen_id', $id)
                ->where('created_at', '<', $fecha_inicio)
                ->groupBy('articulo_id')
        )
        ->get()
        ->keyBy('articulo_id')
        ->toArray();
        

       $data["final"] = Movimiento::query()
        ->select([
            'articulo_id',
            'total_actual',
            'total_actual_defectuosos'
        ])
    
        ->whereIn('id',
            Movimiento::query()
                ->selectRaw('MAX(id)')
                ->where('almacen_id', $id)
                ->where('created_at', '<=', $fecha_fin)
                ->groupBy('articulo_id')
        )
        ->get()
        ->keyBy('articulo_id')
        ->toArray();;

        $data["almacen"]=AlmacenArticulo::with(["almacen.responsable"])->where("almacen_id",$id)->first()->almacen;
        foreach (Movimiento::movibles() as $modelo) {
            $data[$modelo::table()] =
                $this->agregarMovimiento(
                    $modelo,
                    $fecha_inicio,
                    $fecha_fin,
                    $id
                );
        }

        $pdf = PDF::loadView("inventario", $data)->setPaper('letter', 'landscape');;
        return $pdf->stream("inventario.pdf");
    }

    public function reporteInventarioOriginal($id, Request $request)
    {

       
        $fecha_fin = Carbon::parse($request->fecha_fin)->endOfDay();
        $fecha_inicio = $fecha_fin->copy()->subDays(6)->startOfDay();


        
        $data["almacen"]=AlmacenArticulo::with(["almacen.responsable"])->where("almacen_id",$id)->first()->almacen;
        
        $data["fecha"] = "{$fecha_inicio} - {$fecha_fin}";
        $data["dia_semana"]=   (($fecha_fin->dayOfWeekIso+1) % 7) + 1;
        $data["dias"]=[1 =>"D", 2=>"L", 3=>"M", 4=>"M", 5=>"J", 6=>"V" ,7=>"S"]; 


        $data["inventario_inicial"] = Movimiento::query()
        ->select([
            'articulo_id',
            'total_actual',
            'total_actual_defectuosos'
        ])
        ->whereIn('id',
            Movimiento::query()
                ->selectRaw('MAX(id)')
                ->where('almacen_id', $id)
                ->where('created_at', '<', $fecha_inicio)
                ->groupBy('articulo_id')
        )
        ->get()
        ->keyBy('articulo_id')
        ->toArray();


        $data["inventario_final"] = Movimiento::query()
        ->select([
            'articulo_id',
            'total_actual',
            'total_actual_defectuosos'
        ])
        ->whereIn('id',
            Movimiento::query()
                ->selectRaw('MAX(id)')
                ->where('almacen_id', $id)
                ->where('created_at', '<=', $fecha_fin)
                ->groupBy('articulo_id')
        )
        ->get()
        ->keyBy('articulo_id')
        ->toArray();

        $data["articulos"] = AlmacenArticulo::with([
        "articulo.tipoArticulo"
        ])
        ->where("almacen_id",$id)
        ->get()
        ->sortBy('articulo.tipoArticulo.nombre')
        ->values();

        $movibles = DB::table(DB::raw("
            (
                SELECT id as movible_id, 'venta' as movible_type, fecha, created_at FROM ventas
                UNION ALL
                SELECT id, 'carga', fecha, created_at FROM cargas
                UNION ALL
                SELECT id, 'traspaso', fecha, created_at FROM traspasos
                UNION ALL
                SELECT id, 'devolucion', fecha, created_at FROM devoluciones
                UNION ALL
                SELECT id, 'ajuste', fecha, created_at FROM ajustes
                UNION ALL
                SELECT id, 'reclasificacion', fecha, created_at FROM reclasificaciones
            ) as movibles
        "));

        $resultado = Movimiento::query()
            ->selectRaw("
                movimientos.articulo_id,
                DAYOFWEEK(movibles.fecha) as dia_semana,

                SUM(CASE WHEN movimientos.cantidad > 0 THEN movimientos.cantidad ELSE 0 END) as entradas,
                SUM(CASE WHEN movimientos.cantidad < 0 THEN ABS(movimientos.cantidad) ELSE 0 END) as salidas,

                SUM(CASE WHEN movimientos.cantidad_defectuosos > 0 THEN movimientos.cantidad_defectuosos ELSE 0 END) as defectuosos_entradas,
                SUM(CASE WHEN movimientos.cantidad_defectuosos < 0 THEN ABS(movimientos.cantidad_defectuosos) ELSE 0 END) as defectuosos_salidas
            ")
            ->joinSub($movibles, 'movibles', function ($join) {
                $join->on('movibles.movible_id', '=', 'movimientos.movible_id')
                    ->on('movibles.movible_type', '=', 'movimientos.movible_type');
            })
            ->where('movimientos.almacen_id', $id)
            ->whereBetween('movibles.created_at', [$fecha_inicio, $fecha_fin])
            ->groupBy('movimientos.articulo_id', 'dia_semana')
            ->get();

        $data["movimientos"] = $resultado
            ->groupBy('articulo_id')
            ->map(fn($items) => $items->keyBy('dia_semana'))
            ->toArray();

        

        $pdf = PDF::loadView("inventario_original", $data)->setPaper('letter', 'portrait');;
        return $pdf->stream("inventario.pdf");
    }
}
