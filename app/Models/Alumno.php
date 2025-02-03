<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'email', 'telefono'];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'alumno_curso')
                    ->withPivot('fecha_inscripcion')
                    ->withTimestamps();
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'matriculas')
                    ->withTimestamps();
    }
}
