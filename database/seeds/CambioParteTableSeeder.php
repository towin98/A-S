<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CambioParteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Valvula',
            'referencia' => '1',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Manometro',
            'referencia' => '2',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Tubo sifon',
            'referencia' => '3',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Bastago',
            'referencia' => '4',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Resipiente',
            'referencia' => '5',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Empaques',
            'referencia' => '6',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Manguera',
            'referencia' => '7',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Agente extintor NVO',
            'referencia' => '8n',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Agente extintor NVO',
            'referencia' => '8r',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Anillo de verificacion',
            'referencia' => '9',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Etiqueta generica',
            'referencia' => '10',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Pintura',
            'referencia' => '11',
        ]);
        DB::table('cambio_parte_extintor')->insert([
            'nombre_parte_cambio' => 'Cinturon',
            'referencia' => '12',
        ]);
    }
}
