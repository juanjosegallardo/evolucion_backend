<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Almacen;
use App\Models\Articulo;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('almacen_articulo', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Almacen::class)->constrained();
            $table->foreignIdFor(Articulo::class)->constrained();
            $table->integer("cantidad");
            $table->integer("cantidad_defectuosos");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacen_articulo');
    }
};
