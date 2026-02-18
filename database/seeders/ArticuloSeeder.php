<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Articulo;
use App\Models\TipoArticulo;
use Illuminate\Support\Str;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
$tipos = TipoArticulo::all();

        foreach ($tipos as $tipo) {

            // Evitar duplicados si ya existe un GENERICO para ese tipo
            $existe = Articulo::where('tipo_articulo_id', $tipo->id)
                ->where('nombre', 'GENERICO')
                ->exists();

            if (!$existe) {
                Articulo::create([
                    'codigo' => Str::upper(Str::random(10)), // código aleatorio
                    'nombre' => '*',
                    'tipo_articulo_id' => $tipo->id,
                    'cantidad' => 0,
                    'cantidad_defectuosos' => 0,
                ]);
            }
        }

    }
}
