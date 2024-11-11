<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Articulo;
class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articulos = [
            ["codigo"=>"23423423434", "nombre"=>"Alaciadora de plastico","tipo_articulo_id"=>1, "cantidad"=>0, "cantidad_defectuosos"=>1],
            ["codigo"=>"33242342344", "nombre"=>"Alaciadora de metal",  "tipo_articulo_id"=>1, "cantidad"=>0, "cantidad_defectuosos"=>3],
            ["codigo"=>"33242342344", "nombre"=>"Marmol 12 color negra",  "tipo_articulo_id"=>2, "cantidad"=>0, "cantidad_defectuosos"=>3],
            ["codigo"=>"34234234234", "nombre"=>"Marmol 12 color rosa", "tipo_articulo_id"=>2, "cantidad"=>0, "cantidad_defectuosos"=>5],

        ];

        foreach ($articulos as $articulo) {
            Articulo::create($articulo);
        }


    }
}
