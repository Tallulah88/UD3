<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Asignatura;
use App\Models\Profesor;
use App\Models\Curso;

class AsignaturaFactory extends Factory
{
    protected $model = Asignatura::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word(),
            'profesor_id' => Profesor::factory(),
            'curso_id' => Curso::factory(),
        ];
    }
}
