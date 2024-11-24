<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\CargaArticuloController;
use App\Http\Controllers\TraspasoController;
use App\Http\Controllers\TraspasoArticuloController;
use App\Http\Controllers\TipoArticuloController;
use App\Http\Controllers\VentaArticuloController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteLibretaController;




Route::resource("cargas/{id}/articulos", CargaArticuloController::class);
Route::delete("carga_articulo/{id}", [CargaArticuloController::class,"destroy"]);

Route::resource("traspasos/{id}/articulos", TraspasoArticuloController::class);
Route::delete("traspaso_articulo/{id}", [TraspasoArticuloController::class,"destroy"]);

Route::resource("ventas/{id}/articulos", VentaArticuloController::class);
Route::delete("venta_articulo/{id}", [VentaArticuloController::class,"destroy"]);

Route::get("reportes/vendedores/{id}/libreta", [ReporteLibretaController::class, "reporteVendedores"]);

Route::resource("almacenes", AlmacenController::class );
Route::resource("articulos", ArticuloController::class );
Route::resource("cargas", CargaController::class );
Route::resource("vendedores", VendedorController::class );
Route::resource("traspasos", TraspasoController::class );
Route::resource("ventas", VentaController::class );
Route::resource("tipos_articulos", TipoArticuloController::class );