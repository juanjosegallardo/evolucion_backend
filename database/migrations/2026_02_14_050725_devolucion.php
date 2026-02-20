<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Almacen;
use App\Models\Vendedor;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create('devoluciones', function (Blueprint $table) 
        {
            $table->id();
            $table->foreignIdFor(Almacen::class)->constrained();
            $table->foreignId('usuario_vendedor_id')->constrained('users');
            $table->string("notas")->nullable();
            $table->decimal('saldo_restante', 8, 2);
            $table->unsignedInteger("cantidad")->default(0);
            $table->unsignedInteger("cantidad_defectuosos")->default(0);
            $table->enum('estado', [
                'EN_CAPTURA',     // en proceso de creación
                'SOLICITADO',     // creado, pendiente de aprobación
                'VALIDADO',       // aprobado
                'RECHAZADO',
                'CANCELADO'
            ])->default('EN_CAPTURA');
            $table->softDeletes();
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
