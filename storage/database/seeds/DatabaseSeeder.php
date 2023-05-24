<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
        $this->call([CategoriaTableSeeder::class]);
        // $this->call([EncargadoTableSeeder::class]);
        $this->call([PruebaSeeder::class]);
        $this->call([FugaTableSeeder::class]);
        $this->call([CambioParteTableSeeder::class]);
        $this->call([ActividadTableSeeder::class]);
        $this->call([HocolExtintorPortatil::class]);
        $this->call([HocolExtintoresCarretilla::class]);
    }
}
