<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\CargaArticuloController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource("/almacenes", AlmacenController::class );
Route::resource("/articulos", ArticuloController::class );
Route::resource("/cargas", CargaController::class );
Route::resource("/vendedores", VendedorController::class );
Route::resource("/cargas/{id}/articulos", CargaArticuloController::class);
Route::delete("/carga_articulo/{id}", [CargaArticuloController::class,"destroy"]);