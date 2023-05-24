<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nombre' => 'Admin Admin',
            'apellido' => 'apellido apellido',
            'cargo' => 'Tecnico',
            'email' => 'admin@material.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'nombre' => 'Hector Fabio',
            'apellido' => 'Tamayo Andrade',
            'cargo' => 'Administrador',
            'email' => 'hf@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('tamayo12345'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
