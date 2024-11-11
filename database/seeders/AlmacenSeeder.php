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
            ['nombre' => 'Almacén Principal'],
            ['nombre' => 'Almacén Camilo y Jorge'],
            ['nombre' => 'Almacén Santos'],
            ['nombre' => 'Almacén Zabdiel'],
            ['nombre' => 'Almacén Agustín'],
            ['nombre' => 'Almacén Ramón'],
            ['nombre' => 'Almacén Carlos'],

        ];

    
        foreach ($almacenes as $almacen) {
            Almacen::create($almacen);
        }

    }
}
