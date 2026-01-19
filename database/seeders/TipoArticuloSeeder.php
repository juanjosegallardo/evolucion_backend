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
            ["id"=>1, "nombre"=>"ALACIADORA", "precio_credito"=>2290, "precio_contado"=>1145],
            ["id"=>2, "nombre"=>"BAT 12 PZ DE ACERO", "precio_credito"=>4500, "precio_contado"=>2250],
            ["id"=>3, "nombre"=>"BAT 7000", "precio_credito"=>3500, "precio_contado"=>1750],
            ["id"=>4, "nombre"=>"BAT KUNG FU 9PZ", "precio_credito"=>5300, "precio_contado"=>2650],
            ["id"=>5, "nombre"=>"BAT MARMOL 12 PZ", "precio_credito"=>5300, "precio_contado"=>2650],
            ["id"=>6, "nombre"=>"BAT OKLAND", "precio_credito"=>5300, "precio_contado"=>2650],
            ["id"=>7, "nombre"=>"BAT VERSALLES", "precio_credito"=>4500, "precio_contado"=>2250],
            ["id"=>8, "nombre"=>"BATIDORA", "precio_credito"=>2990, "precio_contado"=>1445],
            ["id"=>9, "nombre"=>"BATIDORA ROBOT", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>10, "nombre"=>"BUD 55 LTS", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>11, "nombre"=>"BUD ACERO 6 PZ", "precio_credito"=>3290, "precio_contado"=>2200],
            ["id"=>12, "nombre"=>"BUD JUMBO", "precio_credito"=>2900, "precio_contado"=>2200],
            ["id"=>13, "nombre"=>"BUD MARMOL", "precio_credito"=>4500, "precio_contado"=>2200],
            ["id"=>14, "nombre"=>"BUD MONARCA", "precio_credito"=>4500, "precio_contado"=>2200],
            ["id"=>15, "nombre"=>"BUD WOK", "precio_credito"=>2500, "precio_contado"=>2200],
            ["id"=>16, "nombre"=>"BURRO", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>17, "nombre"=>"CAFETERA", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>18, "nombre"=>"CHOCOMILERA", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>19, "nombre"=>"COBERTOR KZ", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>20, "nombre"=>"COBERTOR MAT", "precio_credito"=>1600, "precio_contado"=>2200],
            ["id"=>21, "nombre"=>"COMAL", "precio_credito"=>1800, "precio_contado"=>2200],
            ["id"=>22, "nombre"=>"COMAL CHICO", "precio_credito"=>1300, "precio_contado"=>2200],
            ["id"=>23, "nombre"=>"COMAL ELECTRICO", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>24, "nombre"=>"COMBO", "precio_credito"=>2300, "precio_contado"=>2200],
            ["id"=>25, "nombre"=>"CONVEXA", "precio_credito"=>2300, "precio_contado"=>2200],
            ["id"=>26, "nombre"=>"CORTA PELO", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>27, "nombre"=>"DUPLETA CHICA", "precio_credito"=>2900, "precio_contado"=>2200],
            ["id"=>28, "nombre"=>"DUPLETA GRANDE", "precio_credito"=>3300, "precio_contado"=>2200],
            ["id"=>29, "nombre"=>"EXTRACTOR", "precio_credito"=>2990, "precio_contado"=>2200],
            ["id"=>30, "nombre"=>"FERRO", "precio_credito"=>1600, "precio_contado"=>2200],
            ["id"=>31, "nombre"=>"FREIDORA DE AIRE", "precio_credito"=>2900, "precio_contado"=>2200],
            ["id"=>32, "nombre"=>"FREIODRA DE ACEITE", "precio_credito"=>3200, "precio_contado"=>2200],
            ["id"=>33, "nombre"=>"HORNO FREIDOR", "precio_credito"=>2500, "precio_contado"=>2200],
            ["id"=>34, "nombre"=>"HORNO MICROONDAS", "precio_credito"=>4500, "precio_contado"=>2200],
            ["id"=>35, "nombre"=>"LICUADORA", "precio_credito"=>2300, "precio_contado"=>2200],
            ["id"=>36, "nombre"=>"MESA", "precio_credito"=>3200, "precio_contado"=>2200],
            ["id"=>37, "nombre"=>"NUTRIBULLET", "precio_credito"=>2900, "precio_contado"=>2200],
            ["id"=>38, "nombre"=>"OLLA 18", "precio_credito"=>2400, "precio_contado"=>2200],
            ["id"=>39, "nombre"=>"OLLA 21", "precio_credito"=>2600, "precio_contado"=>2200],
            ["id"=>40, "nombre"=>"OLLA 28CM", "precio_credito"=>2900, "precio_contado"=>2200],
            ["id"=>41, "nombre"=>"OLLA DE COCIMIENTO LENTO", "precio_credito"=>1990, "precio_contado"=>2200],
            ["id"=>42, "nombre"=>"OLLA EXPRESS", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>43, "nombre"=>"OLLA IMPERIAL", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>44, "nombre"=>"OLLA 13 PZ", "precio_credito"=>2600, "precio_contado"=>2200],
            ["id"=>45, "nombre"=>"OLLAS CLASICAS", "precio_credito"=>4500, "precio_contado"=>2200],
            ["id"=>46, "nombre"=>"OLLAS MARMOL 10", "precio_credito"=>4500, "precio_contado"=>2200],
            ["id"=>47, "nombre"=>"OLLAS MEXICANAS", "precio_credito"=>4500, "precio_contado"=>2200],
            ["id"=>48, "nombre"=>"OLLAS OSLO", "precio_credito"=>4500, "precio_contado"=>2200],
            ["id"=>49, "nombre"=>"OLLITAS 5 PZ", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>50, "nombre"=>"PANINI", "precio_credito"=>2300, "precio_contado"=>2200],
            ["id"=>51, "nombre"=>"PLANCHA", "precio_credito"=>2300, "precio_contado"=>2200],
            ["id"=>52, "nombre"=>"SARTEN ALEGRA", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>53, "nombre"=>"SARTEN ALFA", "precio_credito"=>3900, "precio_contado"=>2200],
            ["id"=>54, "nombre"=>"SARTEN CON COMAL", "precio_credito"=>2400, "precio_contado"=>2200],
            ["id"=>55, "nombre"=>"SARTEN GOLDEN", "precio_credito"=>2400, "precio_contado"=>2200],
            ["id"=>56, "nombre"=>"SARTEN JADE", "precio_credito"=>2700, "precio_contado"=>2200],
            ["id"=>57, "nombre"=>"SARTEN WOK", "precio_credito"=>2900, "precio_contado"=>2200],
            ["id"=>58, "nombre"=>"SECADORA", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>59, "nombre"=>"SET DE CUCHILLOS", "precio_credito"=>1200, "precio_contado"=>2200],
            ["id"=>60, "nombre"=>"SARTEN STONE", "precio_credito"=>2600, "precio_contado"=>2200],
            ["id"=>61, "nombre"=>"VAJILLA CERAMICA", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>62, "nombre"=>"VAJILLA UVA", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>63, "nombre"=>"VAPORERA 4 PZ", "precio_credito"=>2600, "precio_contado"=>2200],
            ["id"=>64, "nombre"=>"VAPORERA 34 L", "precio_credito"=>1500, "precio_contado"=>2200],
            ["id"=>65, "nombre"=>"VAPORERA 45 L", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>66, "nombre"=>"VAPORERA 70 L", "precio_credito"=>2200, "precio_contado"=>2200],
            ["id"=>67, "nombre"=>"VAPORERA 90 L", "precio_credito"=>2300, "precio_contado"=>2200],
            ["id"=>68, "nombre"=>"VENTILADOR", "precio_credito"=>2600, "precio_contado"=>2200],
            ["id"=>69, "nombre"=>"WAFLERA", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>70, "nombre"=>"WOK CERAMICA", "precio_credito"=>1900, "precio_contado"=>2200],
            ["id"=>71, "nombre"=>"WOK ACERO", "precio_credito"=>2100, "precio_contado"=>2200],
        ];
        
            
        foreach ($tipo_articulos as $tipo) {
            TipoArticulo::create($tipo);
        }
    }
}
