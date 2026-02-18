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
            ["id"=>1, "nombre"=>"ALACIADORA", "precio_credito"=>2300, "precio_contado"=>0],
            ["id"=>2, "nombre"=>"BAT 7000", "precio_credito"=>3500, "precio_contado"=>0],
            ["id"=>3, "nombre"=>"BAT MARMOL 12 PZ", "precio_credito"=>5300, "precio_contado"=>0],
            ["id"=>4, "nombre"=>"BAT DORIS", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>5, "nombre"=>"BAT OKLAND", "precio_credito"=>5300, "precio_contado"=>0],
            ["id"=>6, "nombre"=>"BAT ROYAL 19 PZ", "precio_credito"=>5700, "precio_contado"=>0],
            ["id"=>7, "nombre"=>"BAT VERSALLES", "precio_credito"=>4500, "precio_contado"=>0],
            ["id"=>8, "nombre"=>"BATIDORA", "precio_credito"=>2900, "precio_contado"=>0],
            ["id"=>9, "nombre"=>"BATIDORA ROBOT", "precio_credito"=>2200, "precio_contado"=>0],
            ["id"=>10, "nombre"=>"BAT JMA", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>11, "nombre"=>"BOCINA", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>12, "nombre"=>"BUD 55 LTS", "precio_credito"=>1800, "precio_contado"=>0],
            ["id"=>13, "nombre"=>"BUD 6 AC", "precio_credito"=>3300, "precio_contado"=>0],
            ["id"=>14, "nombre"=>"BUD CAMILA", "precio_credito"=>4900, "precio_contado"=>0],
            ["id"=>15, "nombre"=>"BUD JUMBO", "precio_credito"=>2990, "precio_contado"=>0],
            ["id"=>16, "nombre"=>"BUD MARMOL", "precio_credito"=>3500, "precio_contado"=>0],
            ["id"=>17, "nombre"=>"BUD 32 MONARCA", "precio_credito"=>4500, "precio_contado"=>0],
            ["id"=>18, "nombre"=>"BUD WOK", "precio_credito"=>3500, "precio_contado"=>0],
            ["id"=>19, "nombre"=>"CAFETERA", "precio_credito"=>2200, "precio_contado"=>0],
            ["id"=>20, "nombre"=>"CHOCOMILERA", "precio_credito"=>2200, "precio_contado"=>0],
            ["id"=>21, "nombre"=>"COBERTOR KZ", "precio_credito"=>1500, "precio_contado"=>0],
            ["id"=>22, "nombre"=>"COBERTOR MAT", "precio_credito"=>1200, "precio_contado"=>0],
            ["id"=>23, "nombre"=>"COMAL", "precio_credito"=>1800, "precio_contado"=>0],
            ["id"=>24, "nombre"=>"COMAL CHICO", "precio_credito"=>1300, "precio_contado"=>0],
            ["id"=>25, "nombre"=>"COMAL ELECTRICO", "precio_credito"=>2200, "precio_contado"=>0],
            ["id"=>26, "nombre"=>"CONVEXA", "precio_credito"=>2300, "precio_contado"=>0],
            ["id"=>27, "nombre"=>"CORTA PELO", "precio_credito"=>1900, "precio_contado"=>0],
            ["id"=>28, "nombre"=>"CUCHILLOS", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>29, "nombre"=>"DUPLETA CHICA", "precio_credito"=>2900, "precio_contado"=>0],
            ["id"=>30, "nombre"=>"DUPLETA GRANDE", "precio_credito"=>3300, "precio_contado"=>0],
            ["id"=>31, "nombre"=>"EXTRACTOR", "precio_credito"=>2990, "precio_contado"=>0],
            ["id"=>32, "nombre"=>"FERRO", "precio_credito"=>1600, "precio_contado"=>0],
            ["id"=>33, "nombre"=>"FREIDORA DE ACEITE", "precio_credito"=>2900, "precio_contado"=>0],
            ["id"=>34, "nombre"=>"FREIDODRA DE AIRE", "precio_credito"=>3200, "precio_contado"=>0],
            ["id"=>35, "nombre"=>"HORNO FREIDOR", "precio_credito"=>2500, "precio_contado"=>0],
            ["id"=>36, "nombre"=>"HORNO MICROONDAS", "precio_credito"=>4500, "precio_contado"=>0],
            ["id"=>37, "nombre"=>"LICUADORA", "precio_credito"=>2300, "precio_contado"=>0],
            ["id"=>38, "nombre"=>"MESA", "precio_credito"=>3200, "precio_contado"=>0],
            ["id"=>39, "nombre"=>"NUTRIBULLET", "precio_credito"=>2700, "precio_contado"=>0],
            ["id"=>40, "nombre"=>"OLLA 11", "precio_credito"=>2400, "precio_contado"=>0],
            ["id"=>41, "nombre"=>"OLLA 13", "precio_credito"=>2400, "precio_contado"=>0],
            ["id"=>42, "nombre"=>"OLLA 18", "precio_credito"=>2700, "precio_contado"=>0],
            ["id"=>43, "nombre"=>"OLLA 21", "precio_credito"=>2900, "precio_contado"=>0],
            ["id"=>44, "nombre"=>"OLLA 26", "precio_credito"=>2200, "precio_contado"=>0],
            ["id"=>45, "nombre"=>"OLLA 28", "precio_credito"=>2200, "precio_contado"=>0],
            ["id"=>46, "nombre"=>"OLLA ELECTRICA", "precio_credito"=>2600, "precio_contado"=>0],
            ["id"=>47, "nombre"=>"OLLA EXPRESS", "precio_credito"=>4500, "precio_contado"=>0],
            ["id"=>48, "nombre"=>"OLLAS IMPERIAL", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>49, "nombre"=>"OLLAS 13 PZ", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>50, "nombre"=>"OLLAS CLASICAS", "precio_credito"=>3500, "precio_contado"=>0],
            ["id"=>51, "nombre"=>"OLLAS MARMOL 10 PZ", "precio_credito"=>3500, "precio_contado"=>0],
            ["id"=>52, "nombre"=>"OLLAS MEXICANAS", "precio_credito"=>2690, "precio_contado"=>0],
            ["id"=>53, "nombre"=>"OLLAS OSLO", "precio_credito"=>3900, "precio_contado"=>0],
            ["id"=>54, "nombre"=>"OLLITAS 5 PZ", "precio_credito"=>1990, "precio_contado"=>0],
            ["id"=>55, "nombre"=>"PANINI", "precio_credito"=>2700, "precio_contado"=>0],
            ["id"=>56, "nombre"=>"PLANCHA", "precio_credito"=>2200, "precio_contado"=>0],
            ["id"=>57, "nombre"=>"SARTEN ALEGRA", "precio_credito"=>2200, "precio_contado"=>0],
            ["id"=>58, "nombre"=>"SARTEN ALFA", "precio_credito"=>3900, "precio_contado"=>0],
            ["id"=>59, "nombre"=>"SARTEN CON COMAL", "precio_credito"=>2400, "precio_contado"=>0],
            ["id"=>60, "nombre"=>"SARTEN GOLDEN", "precio_credito"=>2690, "precio_contado"=>0],
            ["id"=>61, "nombre"=>"SARTEN 5PZ", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>62, "nombre"=>"SANDWICHERA", "precio_credito"=>1900, "precio_contado"=>0],
            ["id"=>63, "nombre"=>"SARTEN WOK", "precio_credito"=>2990, "precio_contado"=>0],
            ["id"=>64, "nombre"=>"SARTEN STONE", "precio_credito"=>2600, "precio_contado"=>0],
            ["id"=>65, "nombre"=>"S.W. CON TAPA", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>66, "nombre"=>"SECADORA", "precio_credito"=>1900, "precio_contado"=>0],
            ["id"=>67, "nombre"=>"ROPERO", "precio_credito"=>0, "precio_contado"=>0],
            ["id"=>68, "nombre"=>"VAJILLA CERAMICA", "precio_credito"=>2300, "precio_contado"=>0],
            ["id"=>69, "nombre"=>"VAPORERA 4 PZ", "precio_credito"=>2690, "precio_contado"=>0],
            ["id"=>70, "nombre"=>"VAPORERA 34 L", "precio_credito"=>1600, "precio_contado"=>0],
            ["id"=>71, "nombre"=>"VAPORERA 45 L", "precio_credito"=>1900, "precio_contado"=>0],
            ["id"=>72, "nombre"=>"VAPORERA 70 L", "precio_credito"=>2300, "precio_contado"=>0],
            ["id"=>73, "nombre"=>"VAPORERA 90 L", "precio_credito"=>2500, "precio_contado"=>0],
            ["id"=>74, "nombre"=>"VENTILADOR", "precio_credito"=>2600, "precio_contado"=>0],
            ["id"=>75, "nombre"=>"WAFLERA", "precio_credito"=>2200, "precio_contado"=>0],
        ];
        
        foreach ($tipo_articulos as $tipo) {
            TipoArticulo::create($tipo);
        }
    }
}
