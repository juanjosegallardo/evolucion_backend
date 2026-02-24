<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Venta;
use App\Models\Carga;
use App\Models\Devolucion;
use App\Models\Reclasificacion;
use App\Models\Traspaso;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Relation::morphMap([
            'venta' => Venta::class,
            'carga' => Carga::class,
            'devolucion' => Devolucion::class,
            'traspaso' => Traspaso::class,
            'reclasificacion' => Reclasificacion::class,
        ]);

    }
}
