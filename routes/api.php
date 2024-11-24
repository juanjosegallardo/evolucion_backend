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


// Rutas para Carga Artículos
Route::prefix('cargas/{id}')->group(function () {
    Route::resource('articulos', CargaArticuloController::class);
    Route::delete('articulo/{articuloId}', [CargaArticuloController::class, 'destroy']);
});

// Rutas para Traspaso Artículos
Route::prefix('traspasos/{id}')->group(function () {
    Route::resource('articulos', TraspasoArticuloController::class);
    Route::delete('articulo/{articuloId}', [TraspasoArticuloController::class, 'destroy']);
});

// Rutas para Venta Artículos
Route::prefix('ventas/{id}')->group(function () {
    Route::resource('articulos', VentaArticuloController::class);
    Route::delete('articulo/{articuloId}', [VentaArticuloController::class, 'destroy']);
});

// Rutas para reportes
Route::get('reportes/vendedores/{id}/libreta', [ReporteLibretaController::class, 'reporteVendedores']);

// Rutas principales
Route::resources([
    'almacenes' => AlmacenController::class,
    'articulos' => ArticuloController::class,
    'cargas' => CargaController::class,
    'vendedores' => VendedorController::class,
    'traspasos' => TraspasoController::class,
    'ventas' => VentaController::class,
    'tipos_articulos' => TipoArticuloController::class,
]);
