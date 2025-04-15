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
            ["nombre"=>"Camilo"],
            ["nombre"=>"Santos"],
            ["nombre"=>"Zabdiel"],
            ["nombre"=>"Agustin"],
            ["nombre"=>"Ramón"],
            ["nombre"=>"Carlos"]
        ];

        foreach($vendedores as $vendedor)
        {
            Vendedor::create($vendedor);
        }
        
    }
}
