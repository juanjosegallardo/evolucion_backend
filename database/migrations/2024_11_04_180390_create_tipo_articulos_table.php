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
        Schema::create('tipo_articulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->integer("cantidad")->default(0);
            $table->integer("cantidad_defectuosos")->default(0);
            $table->decimal('precio_contado', 8, 2); 
            $table->decimal('precio_credito', 8, 2); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_articulos');
    }
};
