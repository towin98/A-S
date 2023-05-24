<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pruebas')->insert([
            'nombre_prueba' => 'Pintura',
            'abreviacion_prueba' => 'PI',
        ]);
        DB::table('pruebas')->insert([
            'nombre_prueba' => 'Hidrostatica',
            'abreviacion_prueba' => 'hI',
        ]);
        DB::table('pruebas')->insert([
            'nombre_prueba' => 'Hermeticidad',
            'abreviacion_prueba' => 'HE',
        ]);
    }
}
