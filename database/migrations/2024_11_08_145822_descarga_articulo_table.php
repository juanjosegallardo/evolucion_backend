<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Articulo;
use App\Models\Descarga;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('descarga_articulo', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Descarga::class)->constrained();
            $table->foreignIdFor(Articulo::class)->constrained();
            $table->integer("cantidad");
            $table->integer("cantidad_defectuosos");
            $table->integer("operacion")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
