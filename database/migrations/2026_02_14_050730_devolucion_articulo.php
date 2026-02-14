<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devolucion_articulo', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Devolucion::class)->constrained();
            $table->foreignIdFor(Articulo::class)->constrained();
            $table->unsignedInteger("cantidad");
            $table->unsignedInteger("cantidad_defectuosos");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucion_articulo');
    }
};
