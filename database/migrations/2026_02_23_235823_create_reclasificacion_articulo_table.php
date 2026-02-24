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
        Schema::create('reclasificacion_articulo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reclasificacion_id')->constrained('reclasificaciones')->onDelete('cascade');
            $table->foreignId('articulo_id')->constrained('articulos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->integer('cantidad_defectuosos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclasificacion_articulo');
    }
};
