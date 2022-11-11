<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PiezaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pieza')->insert([
            'dni' => '900898',
            'nombre' => 'Beatriz',
            'apellido' => 'Salgado',
            'situacion-dni' => 'Baja por incumplimiento',
            'inscripcion_abierta' => true,
            'inscripta_mipieza' => true,
            'inscripta_estado' => 'ganadora',
            'es_beneficiaria' => true,
            'tiene_cvf' => true,
            'cvf' => 'cvf9283',
            'nro_tramite_dni' => '98767656432',
            'estado_etapa' => 'Ganadores/Inicio Confirmación',
            'de_baja' => true
        ]);
    }
}
