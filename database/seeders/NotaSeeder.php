<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nota;
use App\Models\Alumno;
use App\Models\Asignatura;

class NotaSeeder extends Seeder
{
    public function run()
    {
        $alumnos = Alumno::all();
        $asignaturas = Asignatura::all();

        foreach ($alumnos as $alumno) {
            Nota::factory(3)->create([
                'alumno_id' => $alumno->id,
                'asignatura_id' => $asignaturas->random()->id,
                'calificacion' => rand(1, 10)
            ]);
        }
    }
}
