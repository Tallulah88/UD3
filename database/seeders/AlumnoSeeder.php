<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Curso;

class AlumnoSeeder extends Seeder
{
    public function run()
    {
        Alumno::factory(20)->create()->each(function ($alumno) {
            $cursos = Curso::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $alumno->cursos()->attach($cursos, ['fecha_inscripcion' => now()]);
        });
    }
}
