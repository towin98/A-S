<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            'id' => 1,
            'nombre_categoria' => 'Polvo Quimico Seco',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'id' => 2,
            'nombre_categoria' => 'SOLKAFLAM 123',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'id' => 3,
            'nombre_categoria' => 'Gas Carbonico CO2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'id' => 4,
            'nombre_categoria' => 'Agua a Presion',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'id' => 5,
            'nombre_categoria' => 'PQS Capsula CO2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'id' => 6,
            'nombre_categoria' => 'Tipo K',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'id' => 7,
            'nombre_categoria' => 'MANTENIMIENTO Y RECARGA DE EQUIPOS VARIOS',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'id' => 8,
            'nombre_categoria' => 'ESTAMOS EN CALIDAD DE PRESTAMO',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
