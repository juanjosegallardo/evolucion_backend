<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoArticulo;

class TipoArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo_articulos = [
            ["id"=>1, "nombre"=>"ALACIADORA", "precio_credito"=>2290 , "precio_contado"=>1145],
            ["id"=>2 ,"nombre"=>"MARMOL 12 PZ",  "precio_credito"=>4500 , "precio_contado"=>2250],
            ["id"=>3 ,"nombre"=>"BAT KEIZER",  "precio_credito"=>3500 , "precio_contado"=>1750],
            ["id"=>4 ,"nombre"=>"BAT 7000",  "precio_credito"=>3500 , "precio_contado"=>1750],
            ["id"=>5 ,"nombre"=>"BAT ROYAL 19 PZ",  "precio_credito"=>5500 , "precio_contado"=>2250],
            ["id"=>6 ,"nombre"=>"BAT JADE 7 PZ",  "precio_credito"=>3200 , "precio_contado"=>1600],
            ["id"=>7 ,"nombre"=>"BAT JADE 8 PZ",  "precio_credito"=>4500 , "precio_contado"=>2250],
            ["id"=>8 ,"nombre"=>"BAT KUNG FU 9PZ",  "precio_credito"=>5300 , "precio_contado"=>2650],
            ["id"=>9 ,"nombre"=>"BAT OKLAND",  "precio_credito"=>5300 , "precio_contado"=>2650],
            ["id"=>10 ,"nombre"=>"BAT VERSALLES",  "precio_credito"=>4500 , "precio_contado"=>2250],
            ["id"=>11 ,"nombre"=>"BAT 13 PZ",  "precio_credito"=>4500 , "precio_contado"=>2250],
            ["id"=>12 ,"nombre"=>"BATIDORA",  "precio_credito"=>2990 , "precio_contado"=>1445],
            ["id"=>13 ,"nombre"=>"BATIDORA ROBOT",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>14 ,"nombre"=>"BUD MONARCA",  "precio_credito"=>2500 , "precio_contado"=>2200],
            ["id"=>15 ,"nombre"=>"BUD 36 JADE",  "precio_credito"=>2600 , "precio_contado"=>2200],
            ["id"=>16 ,"nombre"=>"BUD 55 LTS",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>17 ,"nombre"=>"BUD JUMBO",  "precio_credito"=>2900 , "precio_contado"=>2200],
            ["id"=>18 ,"nombre"=>"BUD ACERO 6 PZ",  "precio_credito"=>3290 , "precio_contado"=>2200],
            ["id"=>19 ,"nombre"=>"BUD STONE",  "precio_credito"=>3500 , "precio_contado"=>2200],
            ["id"=>20 ,"nombre"=>"BUD MARMOL",  "precio_credito"=>4500 , "precio_contado"=>2200],
            ["id"=>21 ,"nombre"=>"BURRO",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>23 ,"nombre"=>"CAFETERA",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>24,"nombre"=>"CHOCOMILERA",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>25,"nombre"=>"COBERTOR MAT",  "precio_credito"=>1600 , "precio_contado"=>2200],
            ["id"=>26,"nombre"=>"COBERTOR KZ",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>27,"nombre"=>"COMAL",  "precio_credito"=>1800 , "precio_contado"=>2200],
            ["id"=>28,"nombre"=>"COMAL CHICO",  "precio_credito"=>1300 , "precio_contado"=>2200],
            ["id"=>29,"nombre"=>"COMAL ELECTRICO",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>30,"nombre"=>"COMBO",  "precio_credito"=>2300 , "precio_contado"=>2200],
            ["id"=>31 ,"nombre"=>"CONVEXA",  "precio_credito"=>2300 , "precio_contado"=>2200],
            ["id"=>32,"nombre"=>"CORTA PELO",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>33,"nombre"=>"DUPLETA CHICA",  "precio_credito"=>2900 , "precio_contado"=>2200],
            ["id"=>34,"nombre"=>"DUPLETA GRANDE",  "precio_credito"=>3300 , "precio_contado"=>2200],
            ["id"=>35,"nombre"=>"EXTRACTOR",  "precio_credito"=>2990 , "precio_contado"=>2200],
            ["id"=>36,"nombre"=>"FERRO",  "precio_credito"=>1600 , "precio_contado"=>2200],
            ["id"=>37,"nombre"=>"FREIDORA DE AIRE",  "precio_credito"=>2900 , "precio_contado"=>2200],
            ["id"=>38 ,"nombre"=>"FREIODRA DE ACEITE",  "precio_credito"=>3200 , "precio_contado"=>2200],
            ["id"=>39 ,"nombre"=>"HORNO FREIDOR",  "precio_credito"=>2500 , "precio_contado"=>2200],
            ["id"=>40 ,"nombre"=>"HORNO MICROHONDAS",  "precio_credito"=>4500 , "precio_contado"=>2200],
            ["id"=>41 ,"nombre"=>"LICUADORA",  "precio_credito"=>2300 , "precio_contado"=>2200],
            ["id"=>42 ,"nombre"=>"MESA",  "precio_credito"=>3200 , "precio_contado"=>2200],
            ["id"=>43 ,"nombre"=>"NUTRIBULLET",  "precio_credito"=>2900 , "precio_contado"=>2200],
            ["id"=>44 ,"nombre"=>"OLLA 15",  "precio_credito"=>2300 , "precio_contado"=>2200],
            ["id"=>45 ,"nombre"=>"OLLA 18",  "precio_credito"=>2400 , "precio_contado"=>2200],
            ["id"=>46 ,"nombre"=>"OLLA 21",  "precio_credito"=>2600 , "precio_contado"=>2200],
            ["id"=>47 ,"nombre"=>"OLLA 26",  "precio_credito"=>2900 , "precio_contado"=>2200],
            ["id"=>48 ,"nombre"=>"OLLA 13 PZ",  "precio_credito"=>2600 , "precio_contado"=>2200],
            ["id"=>49 ,"nombre"=>"OLLAS CLASICAS",  "precio_credito"=>4500 , "precio_contado"=>2200],
            ["id"=>50 ,"nombre"=>"OLLA DE COCIMIENTO LENTO",  "precio_credito"=>1990 , "precio_contado"=>2200],
            ["id"=>51 ,"nombre"=>"OLLA EXPRESS",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>52 ,"nombre"=>"OLLAS MEXICANAS",  "precio_credito"=>2600 , "precio_contado"=>2200],
            ["id"=>53 ,"nombre"=>"OLLITAS 5 PZ",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>54,"nombre"=>"PANINI",  "precio_credito"=>2300 , "precio_contado"=>2200],
            ["id"=>55,"nombre"=>"PLANCHA",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>56,"nombre"=>"SARTEN CINSA",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>57 ,"nombre"=>"SARTEN CON TAPA",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>58 ,"nombre"=>"SARTEN JADE",  "precio_credito"=>2700 , "precio_contado"=>2200],
            ["id"=>59 ,"nombre"=>"SARTEN KUNG FU",  "precio_credito"=>3900 , "precio_contado"=>2200],
            ["id"=>60 ,"nombre"=>"SARTEN STONE",  "precio_credito"=>2600 , "precio_contado"=>2200],
            ["id"=>61 ,"nombre"=>"SARTEN ALFA",  "precio_credito"=>3900 , "precio_contado"=>2200],
            ["id"=>62 ,"nombre"=>"SARTEN DE PROMOCION",  "precio_credito"=>1800 , "precio_contado"=>2200],
            ["id"=>63 ,"nombre"=>"SARTEN CON COMAL",  "precio_credito"=>2400 , "precio_contado"=>2200],
            ["id"=>64 ,"nombre"=>"SARTEN NARANJA",  "precio_credito"=>2800 , "precio_contado"=>2200],
            ["id"=>65 ,"nombre"=>"SARTEN WOK",  "precio_credito"=>2900 , "precio_contado"=>2200],
            ["id"=>66 ,"nombre"=>"SARTEN 5 PZ",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>67 ,"nombre"=>"SECADORA",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>68 ,"nombre"=>"SET DE CUCHILLOS",  "precio_credito"=>1200 , "precio_contado"=>2200],
            ["id"=>69 ,"nombre"=>"VAJILLA UVA",  "precio_credito"=>2100 , "precio_contado"=>2200],
            ["id"=>70 ,"nombre"=>"VAJILLA CERAMICA",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>71 ,"nombre"=>"VAPORERA 34 L",  "precio_credito"=>1500 , "precio_contado"=>2200],
            ["id"=>72 ,"nombre"=>"VAPORERA 45 L",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>73 ,"nombre"=>"VAPORERA 70 L",  "precio_credito"=>2200 , "precio_contado"=>2200],
            ["id"=>74 ,"nombre"=>"VAPORERA 90 L",  "precio_credito"=>2300 , "precio_contado"=>2200],
            ["id"=>75 ,"nombre"=>"VAPORERA 100 L",  "precio_credito"=>2500 , "precio_contado"=>2200],
            ["id"=>76 ,"nombre"=>"VAPORERA 4 PZ",  "precio_credito"=>2600 , "precio_contado"=>2200],
            ["id"=>77 ,"nombre"=>"VENTILADOR",  "precio_credito"=>2600 , "precio_contado"=>2200],
            ["id"=>78 ,"nombre"=>"WAFLERA",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>79 ,"nombre"=>"WOK TULA",  "precio_credito"=>1900 , "precio_contado"=>2200],
            ["id"=>80 ,"nombre"=>"WOK ACERO",  "precio_credito"=>2100 , "precio_contado"=>2200],
        ];
            
        foreach ($tipo_articulos as $tipo) {
            TipoArticulo::create($tipo);
        }
    }
}
