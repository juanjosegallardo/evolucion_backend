<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Almacen::class)->constrained();
            $table->foreignIdFor(Vendedor::class)->constrained();
            $table->string("notas")->nullable();
            $table->decimal('saldo_restante', 8, 2);
            $table->unsignedInteger("cantidad")->default(0);
            $table->unsignedInteger("cantidad_defectuosos")->default(0);
            $table->enum('estado', [
                'EN_CAPTURA',     // en proceso de creación
                'SOLICITADO',     // creado, pendiente de aprobación
                'VALIDADO',       // aprobado
                'RECHAZADO'
            ])->default('EN_CAPTURA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolciones');
    }
};
