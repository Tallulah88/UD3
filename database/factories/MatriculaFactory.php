<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Matricula;
use App\Models\Alumno;
use App\Models\Asignatura;

class MatriculaFactory extends Factory
{
    protected $model = Matricula::class;

    public function definition()
    {
        return [
            'alumno_id' => Alumno::inRandomOrder()->first()->id ?? Alumno::factory(),
            'asignatura_id' => Asignatura::inRandomOrder()->first()->id ?? Asignatura::factory(),
        ];
    }
}
