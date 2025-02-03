<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matricula;
use App\Models\Alumno;
use App\Models\Asignatura;

class MatriculaSeeder extends Seeder
{
    public function run()
    {
        $alumnos = Alumno::all();
        $asignaturas = Asignatura::all();

        foreach ($alumnos as $alumno) {
            Matricula::factory(2)->create([
                'alumno_id' => $alumno->id,
                'asignatura_id' => $asignaturas->random()->id
            ]);
        }
    }
}
