<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AlmacenSeeder;
use Database\Seeders\TipoArticuloSeeder;
use Database\Seeders\ArticuloSeeder;
use Database\Seeders\CargaSeeder;
use Database\Seeders\VendedorSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AlmacenSeeder::class,
            TipoArticuloSeeder::class,
            ArticuloSeeder::class,
           // CargaSeeder::class,
            UsuarioSeeder::class,
            VendedorSeeder::class
        ]);
    }
}
