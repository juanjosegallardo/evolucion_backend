<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Traspaso;
use App\Models\Articulo;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('traspaso_articulo', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Traspaso::class)->constrained();
            $table->foreignIdFor(Articulo::class)->constrained();
            $table->unsignedInteger("cantidad");
            $table->unsignedInteger("cantidad_defectuosos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traspaso_articulo');
    }
};
