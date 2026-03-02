<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\AlmacenArticulo;
use App\Models\Movimiento;
use App\Models\Venta;
use App\Models\Carga;
use Carbon\Carbon;
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

        $data["almacen"]=AlmacenArticulo::with(["almacen.responsable"])->where("almacen_id",$id)->first()->almacen;
        
        $data[Venta::table()] =
            $this->agregarMovimiento(Venta::class, $fecha_inicio, $fecha_fin, $id);

        $data[Carga::table()] =
            $this->agregarMovimiento(Carga::class, $fecha_inicio, $fecha_fin, $id);

        $data[Reclasificacion::table()] =
            $this->agregarMovimiento(Reclasificacion::class, $fecha_inicio, $fecha_fin, $id);

        $data[Traspaso::table()] =
            $this->agregarMovimiento(Traspaso::class, $fecha_inicio, $fecha_fin, $id);

    
        $pdf = PDF::loadView("inventario", $data)->setPaper('letter', 'landscape');;
        return $pdf->stream("inventario.pdf");
    }
}
