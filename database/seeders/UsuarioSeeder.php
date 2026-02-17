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
            ["id"=>1, "nombre"=>"Juan Jose Gallardo Mendoza", "usuario"=>"juanjo", "password"=>bcrypt("dext1984"), "role"=>"admin"],
            ["id"=>2, "nombre"=>"Zabidiel Santiago Vega", "usuario"=>"zabdiel", "password"=>bcrypt("zaby45434"), "role"=>"user"],
            ["id"=>3, "nombre"=>"Carlos Garcia Vega", "usuario"=>"carlos", "password"=>bcrypt("car7895455"), "role"=>"user"],
            ["id"=>4, "nombre"=>"Francisco Agustin Magaña Duarte", "usuario"=>"agustin", "password"=>bcrypt("agus545465"), "role"=>"user"],
            ["id"=>5, "nombre"=>"Jesus Santos", "usuario"=>"santos", "password"=>bcrypt("santos456545"), "role"=>"user"],
            ["id"=>6, "nombre"=>"Camilo Gonzalez", "usuario"=>"camilo", "password"=>bcrypt("camilo78978"), "role"=>"user"]

        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }

}
