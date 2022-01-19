<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoVehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //DB::table('catalogo_vehiculo')->truncate();

        // generamos un arreglo
        $array_ = [
            [
                'color' => 'BLANCO',
                'marca' => 'FORD',
                'modelo' => '2009',
                'tipo' => 'SUV',
                'placas' => 'DMW943C',
                'linea' => 'EXPLORER',
                'importe_combustible' => 4000.00,
                'resguardante_id' => 1,
                'numero_serie' => '1FMEU63E19UA03575',
                'numero_motor' => 'N/A'
            ],
            [
                'color' => 'BLANCO',
                'marca' => 'CHEVROLET',
                'modelo' => '2009',
                'tipo' => 'SEDÁN',
                'placas' => 'DMW939C',
                'linea' => 'AVEO',
                'importe_combustible' => 1500.00,
                'resguardante_id' => 2,
                'numero_serie' => '3G1TU51689L137956',
                'numero_motor' => '9L137956'
            ],
            [
                'color' => 'BLANCO',
                'marca' => 'CHEVROLET',
                'modelo' => '2009',
                'tipo' => 'SEDÁN',
                'placas' => 'DMW944C',
                'linea' => 'AVEO',
                'importe_combustible' => 1500.00,
                'resguardante_id' => 2,
                'numero_serie' => '3G1TU51669L141830',
                'numero_motor' => '9L141830'
            ],
            [
                'color' => 'PLATA OXIDO',
                'marca' => 'CHEVROLET',
                'modelo' => '2006',
                'tipo' => 'SEDÁN CONFORT',
                'placas' => 'DMW938C',
                'linea' => 'CHEVY C2',
                'importe_combustible' => 1500.00,
                'resguardante_id' => 2,
                'numero_serie' => '3G1SF61X26S100486',
                'numero_motor' => '2M06206PS'
            ],
            [
                'color' => 'PLATA',
                'marca' => 'NISSAN',
                'modelo' => '2003',
                'tipo' => 'SEDÁN',
                'placas' => 'DMW941C',
                'linea' => 'PLATINA',
                'importe_combustible' => 1500.00,
                'resguardante_id' => 2,
                'numero_serie' => '3N1JH01S53L050397',
                'numero_motor' => 'Q064076'
            ],
            [
                'color' => 'AZUL',
                'marca' => 'CHEVROLET',
                'modelo' => '2001',
                'tipo' => 'PICK UP',
                'placas' => 'CY0347B',
                'linea' => 'LUV DOBLE CABINA',
                'importe_combustible' => 1500.00,
                'resguardante_id' => 2,
                'numero_serie' => '8GGTFRC141A096513',
                'numero_motor' => 'C22NE25037008'
            ],
            [
                'color' => 'WHITE PEARL',
                'marca' => 'KIA',
                'modelo' => '2021',
                'tipo' => 'SUV',
                'placas' => 'DSB552C',
                'linea' => 'NEW SPORTAGE',
                'importe_combustible' => 2000.00,
                'resguardante_id' => 1,
                'numero_serie' => 'U6YPH3AA6ML978092',
                'numero_motor' => 'G4NALH329824'
            ],
            [
                'color' => 'BLANCO',
                'marca' => 'NISSAN',
                'modelo' => '2020',
                'tipo' => 'PICK UP',
                'placas' => 'CV1338C',
                'linea' => 'NP300',
                'importe_combustible' =>  0.00,
                'resguardante_id' => 2,
                'numero_serie' => '3N6AD31A2LK870280',
                'numero_motor' => 'QR25386159H'
            ],
            [
                'color' => 'BLANCO',
                'marca' => 'NISSAN',
                'modelo' => '2020',
                'tipo' => 'SEDAN',
                'placas' => 'DSB554C',
                'linea' => 'V-DRIVE',
                'importe_combustible' => 1500.00,
                'resguardante_id' => 3,
                'numero_serie' => '3N1CN7AD8LK411798',
                'numero_motor' => 'HR16094584V'
            ],
            [
                'color' => 'BLANCO',
                'marca' => 'NISSAN',
                'modelo' => '2020',
                'tipo' => 'SEDAN',
                'placas' => 'DSB558C',
                'linea' => 'V-DRIVE',
                'importe_combustible' => 0.00,
                'resguardante_id' => 2,
                'numero_serie' => '3N1CN7AD6LK411802',
                'numero_motor' => 'HR16094571V'
            ],
            [
                'color' => 'N/A',
                'marca' => 'REMOLQUE',
                'modelo' => '2009',
                'tipo' => 'N/A',
                'placas' => '1BT2689',
                'linea' => 'N/A',
                'importe_combustible' => 0.00,
                'resguardante_id' => 4,
                'numero_serie' => 'N/A',
                'numero_motor' => 'N/A'
            ],
            [
                'color' => 'N/A',
                'marca' => 'REMOLQUE',
                'modelo' => '2009',
                'tipo' => 'N/A',
                'placas' => '1BT2693',
                'linea' => 'N/A',
                'importe_combustible' => 0.00,
                'resguardante_id' => 4,
                'numero_serie' => 'N/A',
                'numero_motor' => 'N/A'
            ],
            [
                'color' => 'N/A',
                'marca' => 'REMOLQUE',
                'modelo' => '2009',
                'tipo' => 'N/A',
                'placas' => '1BT3306',
                'linea' => 'N/A',
                'importe_combustible' => 0.00,
                'resguardante_id' => 4,
                'numero_serie' => 'N/A',
                'numero_motor' => 'N/A'
            ],
            [
                'color' => 'N/A',
                'marca' => 'REMOLQUE',
                'modelo' => '2009',
                'tipo' => 'N/A',
                'placas' => '1BT2692',
                'linea' => 'N/A',
                'importe_combustible' => 0.00,
                'resguardante_id' => 4,
                'numero_serie' => 'N/A',
                'numero_motor' => 'N/A'
            ],
            [
                'color' => 'N/A',
                'marca' => 'REMOLQUE',
                'modelo' => '2009',
                'tipo' => 'N/A',
                'placas' => '1BT2691',
                'linea' => 'N/A',
                'importe_combustible' => 0.00,
                'resguardante_id' => 4,
                'numero_serie' => 'N/A',
                'numero_motor' => 'N/A'
            ],
            [
                'color' => 'N/A',
                'marca' => 'REMOLQUE',
                'modelo' => '2009',
                'tipo' => 'N/A',
                'placas' => '1BT3304',
                'linea' => 'N/A',
                'importe_combustible' => 0.00,
                'resguardante_id' => 4,
                'numero_serie' => 'N/A',
                'numero_motor' => 'N/A'
            ],
            [
                'color' => 'N/A',
                'marca' => 'REMOLQUE',
                'modelo' => '2009',
                'tipo' => 'N/A',
                'placas' => '1BT3305',
                'linea' => 'N/A',
                'importe_combustible' => 0.00,
                'resguardante_id' => 4,
                'numero_serie' => 'N/A',
                'numero_motor' => 'N/A'
            ]
        ];

        // hacemos una insercion
        DB::table('catalogo_vehiculo')->insert($array_);
    }
}
