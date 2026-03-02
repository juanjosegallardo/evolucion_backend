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

        $data["articulos"] = AlmacenArticulo::with([
            "articulo.tipoArticulo"
        ])
        ->where("almacen_id",$id)
        ->get()
        ->sortBy('articulo.tipoArticulo.nombre')
        ->values();

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
}
