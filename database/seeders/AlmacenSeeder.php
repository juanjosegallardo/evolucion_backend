<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Almacen;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $almacenes = [
            ['nombre' => 'Ranger 4x4'],
            ['nombre' => 'Dakota verde'],
            ['nombre' => 'Ranger Roja'],
            ['nombre' => 'Ranger 4 cilindros'],
            ['nombre' => 'Ranger Blanca Camper'],
            ['nombre' => 'Ranger Redilas'],
            ['nombre' => 'Dakota Azul'],
            ['nombre' => 'Ranger Cafe'],

        ];

    
        foreach ($almacenes as $almacen) {
            Almacen::create($almacen);
        }

    }
}
