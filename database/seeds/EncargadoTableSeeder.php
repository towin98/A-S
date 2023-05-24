<?php

use App\Models\Encargado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EncargadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Encargado::class)->times(10)->create();
    }
}
