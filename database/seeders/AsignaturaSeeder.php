<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asignatura;
use App\Models\Profesor;
use App\Models\Curso;

class AsignaturaSeeder extends Seeder
{
    public function run()
    {
        $profesores = Profesor::all();
        $cursos = Curso::all();

        if ($cursos->count() == 0) {
            Curso::factory(5)->create();
            $cursos = Curso::all();
        }

        foreach ($profesores as $profesor) {
            Asignatura::factory(3)->create([
                'profesor_id' => $profesor->id,
                'curso_id' => $cursos->random()->id
            ]);
        }
    }
}
