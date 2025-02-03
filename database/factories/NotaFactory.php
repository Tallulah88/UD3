<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Nota;
use App\Models\Alumno;
use App\Models\Asignatura;

class NotaFactory extends Factory
{
    protected $model = Nota::class;

    public function definition()
    {
        return [
            'alumno_id' => Alumno::inRandomOrder()->first()->id ?? Alumno::factory(),
            'asignatura_id' => Asignatura::inRandomOrder()->first()->id ?? Asignatura::factory(),
            'calificacion' => $this->faker->numberBetween(1, 10),
        ];
    }
}
