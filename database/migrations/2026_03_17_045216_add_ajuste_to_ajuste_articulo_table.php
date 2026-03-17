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
        Schema::table('ajuste_articulo', function (Blueprint $table) {
            $table->foreignId('ajuste_id')->constrained('ajustes')->onDelete('cascade');
            $table->foreignId('articulo_id')->constrained('articulos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->integer('cantidad_defectuosos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ajuste_articulo', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ajuste_id');
            $table->dropConstrainedForeignId('articulo_id');

            $table->dropColumn(['cantidad', 'cantidad_defectuosos']);
        });
    }
};
