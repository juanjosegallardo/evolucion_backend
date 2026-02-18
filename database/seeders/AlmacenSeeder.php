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
            ["id"=>1, 'nombre' => 'Ranger 4x4', "user_responsable_id"=>2],
            ["id"=>2, 'nombre' => 'Dakota verde', "user_responsable_id"=>3],
            ["id"=>3, 'nombre' => 'Ranger Roja', "user_responsable_id"=>5],
            ["id"=>4, 'nombre' => 'Ranger 4 cilindros', "user_responsable_id"=>7],
            ["id"=>5, 'nombre' => 'Ranger Blanca Camper', "user_responsable_id"=>4],
            ["id"=>6, 'nombre' => 'Ranger Redilas'],
            ["id"=>7, 'nombre' => 'Dakota Azul', "user_responsable_id"=>6],
            ["id"=>8, 'nombre' => 'Ranger Cafe', "user_responsable_id"=>8],

        ];

    
        foreach ($almacenes as $almacen) {
            Almacen::create($almacen);
        }

    }
}
