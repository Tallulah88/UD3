<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Alumno;

class CursoController extends Controller
{
    // Obtener todos los cursos
    public function index()
    {
        return response()->json(Curso::with('alumnos')->get(), 200);
    }

    // Crear un nuevo curso
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $curso = Curso::create($request->all());

        return response()->json($curso, 201);
    }

    // Obtener un curso por ID
    public function show($id)
    {
        $curso = Curso::with('alumnos')->find($id);
        if (!$curso) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }

        return response()->json($curso, 200);
    }

    // Actualizar un curso
    public function update(Request $request, $id)
    {
        $curso = Curso::find($id);
        if (!$curso) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'string|max:255'
        ]);

        $curso->update($request->all());

        return response()->json($curso, 200);
    }

    // Eliminar un curso
    public function destroy($id)
    {
        $curso = Curso::find($id);
        if (!$curso) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }

        $curso->delete();

        return response()->json(['message' => 'Curso eliminado'], 200);
    }

    // Asignar un alumno a un curso
    public function asignarAlumno($curso_id, $alumno_id)
    {
        $curso = Curso::findOrFail($curso_id);
        $alumno = Alumno::findOrFail($alumno_id);

        // Evitar duplicados
        if (!$curso->alumnos()->where('alumno_id', $alumno_id)->exists()) {
            $curso->alumnos()->attach($alumno, ['fecha_inscripcion' => now()]);
            return response()->json(['message' => 'Alumno asignado al curso'], 200);
        } else {
            return response()->json(['message' => 'El alumno ya está inscrito en este curso'], 409);
        }
    }

    // Eliminar un alumno de un curso
    public function eliminarAlumno($curso_id, $alumno_id)
    {
        $curso = Curso::findOrFail($curso_id);
        $alumno = Alumno::findOrFail($alumno_id);

        if ($curso->alumnos()->where('alumno_id', $alumno_id)->exists()) {
            $curso->alumnos()->detach($alumno);
            return response()->json(['message' => 'Alumno eliminado del curso'], 200);
        } else {
            return response()->json(['message' => 'El alumno no está inscrito en este curso'], 404);
        }
    }

    // Obtener alumnos de un curso específico
    public function obtenerAlumnos($curso_id)
    {
        $curso = Curso::with('alumnos')->find($curso_id);
        if (!$curso) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }

        return response()->json($curso->alumnos, 200);
    }
}
