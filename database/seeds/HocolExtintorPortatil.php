<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HocolExtintorPortatil extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'VÁLVULA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'MANÓMETRO',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'PASADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'SELLO PLÁSTICO',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'ANILLO VERIFICACIÓN',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'ETIQUETADO (ADHESIVO)',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'CILINDRO',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'SOPORTE',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'ETIQUETA DE INSPECCIÓN',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'SEÑALIZACIÓN',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'ALTURA / VISIBILIDAD',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'MANGUERA ',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'BOQUILLA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'PINTURA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'ACCESO',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintor_portatil')->insert([
            'nombreParteExtintor' => 'PRESIÓN',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
