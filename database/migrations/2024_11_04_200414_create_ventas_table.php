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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 8, 2);
            $table->decimal('total_real', 8, 2)->default(0);  
            $table->decimal('porcentaje', 8, 2);
            $table->decimal('enganche', 8, 2);
            $table->decimal('comision',8,2 );
            $table->decimal('a_pagar',8,2 );
            $table->unsignedInteger("cantidad")->default(0);
            $table->unsignedInteger("cantidad_defectuosos")->default(0);
            $table->date("fecha");//para saber el dia de la semana que vendio
            $table->string("tipo");
            $table->foreignIdFor(Almacen::class)->constrained();
            $table->foreignId('user_vendedor_id')->constrained('users');
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
        Schema::dropIfExists('ventas');
    }
};
