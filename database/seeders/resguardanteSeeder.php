<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\solicitud\Resguardante;

class resguardanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // generamos un arreglo
        $arreglo = [
            [
                'resguardante_unidad' => 'MTRA. FABIOLA LIZBETH ASTUDILLO REYES',
                'puesto_resguardante_unidad' => 'DIRECTORA GENERAL',
                'created_at' => Carbon::now()
            ],
            [
                'resguardante_unidad' => 'LIC. ISABEL CRISTINA RIOS MIJANGOS',
                'puesto_resguardante_unidad' => 'TITULAR DEPARTAMENTO DE RECURSOS MATERIALES',
                'created_at' => Carbon::now()
            ],
            [
                'resguardante_unidad' => 'MTRO. WALTER DOMÍNGUEZ CAMACHO',
                'puesto_resguardante_unidad' => 'TITULAR DIRECCIÓN ADMINISTRATIVA',
                'created_at' => Carbon::now()
            ],
            [
                'resguardante_unidad' => 'LIC. JAVIER ENRIQUE LÓPEZ RUÍZ',
                'puesto_resguardante_unidad' => 'TITULAR UNIDAD EJECUTIVA',
                'created_at' => Carbon::now()
            ]
        ];

        // hacemos una insercion
        Resguardante::insert($arreglo);
    }
}
