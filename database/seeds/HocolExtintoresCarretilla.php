<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HocolExtintoresCarretilla extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'P.H BALA N2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'VÁLVULA BALA N2"
',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'REGULADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'MANÓMETRO 0 - 400',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'MANÓMETRO 0 - 4000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'RUEDAS',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'TAPA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'MANIJA TRANSPORTE',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'PRESIÓN BOTELLA N2 PSI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'MANGUERA TANQUE REGULADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'SOPORTE MANGUERA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'MANGUERA DE DESCARGA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('hocol_extintores_carretilla')->insert([
            'nombreParteExtintorCarretilla' => 'FORRO',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
