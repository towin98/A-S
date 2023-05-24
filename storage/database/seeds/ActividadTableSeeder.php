<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actividades')->insert([
            'nombre_actividad' => 'Recarga',
            'abreviacion_actividad' => 'RGC',
        ]);
        DB::table('actividades')->insert([
            'nombre_actividad' => 'Revision',
            'abreviacion_actividad' => 'RVS',
        ]);
        DB::table('actividades')->insert([
            'nombre_actividad' => 'Nuevo',
            'abreviacion_actividad' => 'NVO',
        ]);
    }
}
