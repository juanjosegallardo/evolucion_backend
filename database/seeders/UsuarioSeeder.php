<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            ["id"=>1, "nombre"=>"Juan Jose Gallardo Mendoza", "usuario"=>"juan", "password"=>bcrypt(12345)],
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }

}
