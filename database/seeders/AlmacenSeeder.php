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
            ['nombre' => 'Principal'],
            ['nombre' => 'Camilo'],
            ['nombre' => 'Santos'],
            ['nombre' => 'Zabdiel'],
            ['nombre' => 'Agustín'],
            ['nombre' => 'Ramón'],
            ['nombre' => 'Carlos'],

        ];

    
        foreach ($almacenes as $almacen) {
            Almacen::create($almacen);
        }

    }
}
