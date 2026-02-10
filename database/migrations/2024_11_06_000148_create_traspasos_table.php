<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Almacen;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('traspasos', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Almacen::class, 'almacen_origen_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(Almacen::class, 'almacen_destino_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('traspasos');
    }
};
