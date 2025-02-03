<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_curso')
                    ->withPivot('fecha_inscripcion')
                    ->withTimestamps();
    }
}
