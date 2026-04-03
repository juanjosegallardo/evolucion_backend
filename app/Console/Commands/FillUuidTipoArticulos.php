<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\TipoArticulo;

class FillUuidTipoArticulos extends Command
{
    protected $signature = 'tipo-articulos:fill-uuid';
    protected $description = 'Llena el campo UUID en tipos de artículos existentes';

    public function handle()
    {
        $this->info('Iniciando generación de UUIDs...');

        $total = 0;

        TipoArticulo::whereNull('uuid')
            ->chunkById(100, function ($tipo_articulos) use (&$total) {

                foreach ($tipo_articulos as $tipo_articulo) {
                    $tipo_articulo->uuid = (string) Str::uuid();
                    $tipo_articulo->saveQuietly();
                    $total++;
                }

                $this->info("Procesados: {$total}");
            });

        $this->info("Finalizado. Total actualizados: {$total}");

        return Command::SUCCESS;
    }
}