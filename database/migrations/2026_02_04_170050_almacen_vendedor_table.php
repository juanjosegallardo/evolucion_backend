<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('almacen_vendedor', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendedor_id')
                ->constrained('vendedores')
                ->cascadeOnDelete();

            $table->foreignId('almacen_id')
                ->constrained('almacenes')
                ->cascadeOnDelete();

            $table->boolean('activo')->default(true);

            $table->timestamps();

            // Evita duplicados
            $table->unique(['vendedor_id', 'almacen_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('almacen_vendedor');
    }
};
