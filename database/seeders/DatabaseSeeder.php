<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AlumnoSeeder::class,
            ProfesorSeeder::class,
            CursoSeeder::class,
            AsignaturaSeeder::class,
            MatriculaSeeder::class,
            NotaSeeder::class,
        ]);
    }
}
