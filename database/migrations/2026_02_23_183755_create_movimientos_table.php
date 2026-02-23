<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Articulo;
use App\Models\Almacen ;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Articulo::class)->constrained();
            $table->foreignIdFor(Almacen::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            //$table->enum('tipo', ['entrada', 'salida']);
            $table->integer("cantidad");
            $table->integer("cantidad_defectuosos");
            $table->unsignedBigInteger("total_actual");
            $table->unsignedBigInteger("total_actual_defectuosos");
            $table->unsignedBigInteger('movible_id');
            $table->string('movible_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
