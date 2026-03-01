<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\AlmacenArticulo;
use App\Models\Movimiento;
use App\Models\Venta;
use App\Models\Carga;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteInventarioController extends Controller
{
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
        
        $data["cargas"] =  Movimiento::query()
            ->selectRaw('
                movimientos.articulo_id,
                DAYOFWEEK(cargas.fecha) as dia_semana,
                SUM(COALESCE(movimientos.cantidad,0)) as cantidad,
                SUM(COALESCE(movimientos.cantidad_defectuosos,0)) as cantidad_defectuosos
            ')
            ->join('cargas', function ($join) {
                $join->on('cargas.id', '=', 'movimientos.movible_id')
                    ->where('movimientos.movible_type', Carga::morph());
            })
            ->where('movimientos.almacen_id', $id)
            ->whereBetween('cargas.fecha', [$fecha_inicio, $fecha_fin])
            ->groupBy('movimientos.articulo_id', 'dia_semana')
            ->get()
            ->groupBy('articulo_id')
            ->map(function ($items) {
                return $items->keyBy('dia_semana');
            })
            ->toArray();
        

        $data["ventas"] =  Movimiento::query()
            ->selectRaw('
                movimientos.articulo_id,
                DAYOFWEEK(ventas.fecha) as dia_semana,
                SUM(COALESCE(movimientos.cantidad,0)) as cantidad,
                SUM(COALESCE(movimientos.cantidad_defectuosos,0)) as cantidad_defectuosos
            ')
            ->join('ventas', function ($join) {
                $join->on('ventas.id', '=', 'movimientos.movible_id')
                    ->where('movimientos.movible_type', Venta::morph());
            })
            ->where('movimientos.almacen_id', $id)
            ->whereBetween('ventas.fecha', [$fecha_inicio, $fecha_fin])
            ->groupBy('movimientos.articulo_id', 'dia_semana')
            ->get()
            ->groupBy('articulo_id')
            ->map(function ($items) {
                return $items->keyBy('dia_semana');
            })
            ->toArray();

        $pdf = PDF::loadView("inventario", $data);
        return $pdf->stream("inventario.pdf");

    }
}
