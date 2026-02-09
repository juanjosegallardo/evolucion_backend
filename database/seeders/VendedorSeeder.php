<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendedor;

class VendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendedores = [
            ["nombre"=>"Camilo", "user_id" =>1],
            ["nombre"=>"Santos", "user_id" =>1],
            ["nombre"=>"Zabdiel", "user_id" =>1],
            ["nombre"=>"Agustin", "user_id" =>1],
            ["nombre"=>"Ramón", "user_id" =>1],
            ["nombre"=>"Carlos", "user_id" =>1]
        ];

        foreach($vendedores as $vendedor)
        {
            Vendedor::create($vendedor);
        }
        
    }
}
