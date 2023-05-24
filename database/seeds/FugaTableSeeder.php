<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FugaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fugas')->insert([
            'nombre_fuga' => 'En el niple',
            'abreviacion_fuga' => 'A',
        ]);
        DB::table('fugas')->insert([
            'nombre_fuga' => 'En el recipiente',
            'abreviacion_fuga' => 'B',
        ]);
        DB::table('fugas')->insert([
            'nombre_fuga' => 'En la valvula',
            'abreviacion_fuga' => 'C',
        ]);
        DB::table('fugas')->insert([
            'nombre_fuga' => 'Acomodada de mango',
            'abreviacion_fuga' => 'D',
        ]);
    }
}
