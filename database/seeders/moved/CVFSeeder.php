<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CVFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cvf')->insert([
            [
                'dni' => "123456",
                'nombre' => "Ana",
                'apellido' => 'Bolena',
                'f01' => 'pendiente',
                'f02' => 'pendiente',
                'f03' => 'pendiente',
                'f04' => 'pendiente',
                'f05' => 'pendiente',
                'encuesta_realizada' => true,
                'tiene_cvf' => false,
                'cvf' => 'cvf9394'
            ],
            [
                'dni' => "748384",
                'nombre' => "Julia",
                'apellido' => 'Jimenez',
                'f01' => 'cargada',
                'f02' => 'pendiente',
                'f03' => 'pendiente',
                'f04' => 'pendiente',
                'f05' => 'pendiente',
                'encuesta_realizada' => true,
                'tiene_cvf' => false,
                'cvf' => 'cvf8743'
            ],
            [
                'dni' => "8327421",
                'nombre' => "Paula",
                'apellido' => 'Nuñez',
                'f01' => 'pendiente',
                'f02' => 'pendiente',
                'f03' => 'pendiente',
                'f04' => 'pendiente',
                'f05' => 'pendiente',
                'encuesta_realizada' => true,
                'tiene_cvf' => false,
                'cvf' => 'cvf8123'
            ],
            [
                'dni' => "3847282",
                'nombre' => "Verónica",
                'apellido' => 'Grimaldi',
                'f01' => 'pendiente',
                'f02' => 'pendiente',
                'f03' => 'pendiente',
                'f04' => 'pendiente',
                'f05' => 'pendiente',
                'encuesta_realizada' => true,
                'tiene_cvf' => false,
                'cvf' => 'cvf1090'
            ],
            [
                'dni' => "8372723",
                'nombre' => "Ramona",
                'apellido' => 'Rawson',
                'f01' => 'pendiente',
                'f02' => 'pendiente',
                'f03' => 'pendiente',
                'f04' => 'pendiente',
                'f05' => 'pendiente',
                'encuesta_realizada' => false,
                'tiene_cvf' => false,
                'cvf' => 'cvf8887'
            ],
            [
                'dni' => "8371827",
                'nombre' => "Diana",
                'apellido' => 'Quevedo',
                'f01' => 'pendiente',
                'f02' => 'pendiente',
                'f03' => 'pendiente',
                'f04' => 'pendiente',
                'f05' => 'pendiente',
                'encuesta_realizada' => true,
                'tiene_cvf' => false,
                'cvf' => 'cvf0098'
            ],
            [
                'dni' => "3849222",
                'nombre' => "Lucila",
                'apellido' => 'Gómez',
                'f01' => 'pendiente',
                'f02' => 'pendiente',
                'f03' => 'pendiente',
                'f04' => 'pendiente',
                'f05' => 'pendiente',
                'encuesta_realizada' => true,
                'tiene_cvf' => false,
                'cvf' => 'cvf9898'
            ]
        ]);
    }
}
