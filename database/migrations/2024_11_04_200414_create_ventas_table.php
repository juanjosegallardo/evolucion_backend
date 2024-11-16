<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendedor;
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
            $table->decimal('porcentaje', 8, 2);
            $table->decimal('enganche', 8, 2);
            $table->decimal('comision',8,2 );
            $table->decimal('a_pagar',8,2 );
            $table->integer("operacion")->nullable(); //para relacionar con el otro sistema
            
            $table->string("tipo");
            $table->foreignIdFor(Almacen::class)->constrained();
            $table->foreignIdFor(Vendedor::class)->constrained();
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
