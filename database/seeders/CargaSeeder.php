<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carga;

class CargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargas = [
            ["almacen_id"=>1, "cantidad"=>3],
            ["almacen_id"=>1, "cantidad"=>2],
            
        ];
        foreach($cargas as $carga)
        {
            Carga::create($carga);
        }
    }
}
