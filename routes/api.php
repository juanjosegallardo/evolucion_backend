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


// Carga Artículos
Route::prefix('carga_articulo')->group(function () {
    Route::get('/', [CargaArticuloController::class, 'index'])->name('cargas.articulos.index');
    Route::post('/', [CargaArticuloController::class, 'store'])->name('cargas.articulos.store');
    Route::get('/{articuloId}', [CargaArticuloController::class, 'show'])->name('cargas.articulos.show');
    Route::put('/{articuloId}', [CargaArticuloController::class, 'update'])->name('cargas.articulos.update');
    Route::delete('/{articuloId}', [CargaArticuloController::class, 'destroy'])->name('cargas.articulos.destroy');
});

// Traspaso Artículos
Route::prefix('traspaso_articulo')->group(function () {
    Route::get('/', [TraspasoArticuloController::class, 'index'])->name('traspasos.articulos.index');
    Route::post('/', [TraspasoArticuloController::class, 'store'])->name('traspasos.articulos.store');
    Route::get('/{articuloId}', [TraspasoArticuloController::class, 'show'])->name('traspasos.articulos.show');
    Route::put('/{articuloId}', [TraspasoArticuloController::class, 'update'])->name('traspasos.articulos.update');
    Route::delete('/{articuloId}', [TraspasoArticuloController::class, 'destroy'])->name('traspasos.articulos.destroy');
});

// Venta Artículos
Route::prefix('ventas_articulos')->group(function () {
    Route::get('/', [VentaArticuloController::class, 'index'])->name('ventas.articulos.index');
    Route::post('/', [VentaArticuloController::class, 'store'])->name('ventas.articulos.store');
    Route::get('/{articuloId}', [VentaArticuloController::class, 'show'])->name('ventas.articulos.show');
    Route::put('/{articuloId}', [VentaArticuloController::class, 'update'])->name('ventas.articulos.update');
    Route::delete('/{articuloId}', [VentaArticuloController::class, 'destroy'])->name('ventas.articulos.destroy');
});

// Reportes
Route::get('reportes/vendedores/{id}/libreta', [ReporteLibretaController::class, 'reporteVendedores'])
    ->name('reportes.vendedores.libreta');

// Almacenes
Route::prefix('almacenes')->group(function () {
    Route::get('/', [AlmacenController::class, 'index'])->name('almacenes.index');
    Route::post('/', [AlmacenController::class, 'store'])->name('almacenes.store');
    Route::get('/{id}', [AlmacenController::class, 'show'])->name('almacenes.show');
    Route::put('/{id}', [AlmacenController::class, 'update'])->name('almacenes.update');
    Route::delete('/{id}', [AlmacenController::class, 'destroy'])->name('almacenes.destroy');
});

// Artículos
Route::prefix('articulos')->group(function () {
    Route::get('/', [ArticuloController::class, 'index'])->name('articulos.index');
    Route::post('/', [ArticuloController::class, 'store'])->name('articulos.store');
    Route::get('/{id}', [ArticuloController::class, 'show'])->name('articulos.show');
    Route::put('/{id}', [ArticuloController::class, 'update'])->name('articulos.update');
    Route::delete('/{id}', [ArticuloController::class, 'destroy'])->name('articulos.destroy');
});

// Cargas
Route::prefix('cargas')->group(function () {
    Route::get('/', [CargaController::class, 'index'])->name('cargas.index');
    Route::post('/', [CargaController::class, 'store'])->name('cargas.store');
    Route::get('/{id}', [CargaController::class, 'show'])->name('cargas.show');
    Route::put('/{id}', [CargaController::class, 'update'])->name('cargas.update');
    Route::delete('/{id}', [CargaController::class, 'destroy'])->name('cargas.destroy');
});

// Vendedores
Route::prefix('vendedores')->group(function () {
    Route::get('/', [VendedorController::class, 'index'])->name('vendedores.index');
    Route::post('/', [VendedorController::class, 'store'])->name('vendedores.store');
    Route::get('/{id}', [VendedorController::class, 'show'])->name('vendedores.show');
    Route::put('/{id}', [VendedorController::class, 'update'])->name('vendedores.update');
    Route::delete('/{id}', [VendedorController::class, 'destroy'])->name('vendedores.destroy');
});

// Traspasos
Route::prefix('traspasos')->group(function () {
    Route::get('/', [TraspasoController::class, 'index'])->name('traspasos.index');
    Route::post('/', [TraspasoController::class, 'store'])->name('traspasos.store');
    Route::get('/{id}', [TraspasoController::class, 'show'])->name('traspasos.show');
    Route::put('/{id}', [TraspasoController::class, 'update'])->name('traspasos.update');
    Route::delete('/{id}', [TraspasoController::class, 'destroy'])->name('traspasos.destroy');
});

// Ventas
Route::prefix('ventas')->group(function () {
    Route::get('/', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('/', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/{id}', [VentaController::class, 'show'])->name('ventas.show');
    Route::put('/{id}', [VentaController::class, 'update'])->name('ventas.update');
    Route::delete('/{id}', [VentaController::class, 'destroy'])->name('ventas.destroy');
});

// Tipos de Artículos
Route::prefix('tipos_articulos')->group(function () {
    Route::get('/', [TipoArticuloController::class, 'index'])->name('tipos_articulos.index');
    Route::post('/', [TipoArticuloController::class, 'store'])->name('tipos_articulos.store');
    Route::get('/{id}', [TipoArticuloController::class, 'show'])->name('tipos_articulos.show');
    Route::put('/{id}', [TipoArticuloController::class, 'update'])->name('tipos_articulos.update');
    Route::delete('/{id}', [TipoArticuloController::class, 'destroy'])->name('tipos_articulos.destroy');
});
