<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Alumno;

class CursoSeeder extends Seeder
{
    public function run()
    {
        $cursos = Curso::factory(5)->create();

        $alumnos = Alumno::all();

        foreach ($alumnos as $alumno) {
            $cursosAleatorios = $cursos->random(rand(1, 2));
            $alumno->cursos()->attach($cursosAleatorios);
        }
    }
}
