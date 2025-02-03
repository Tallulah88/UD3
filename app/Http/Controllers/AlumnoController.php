<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Curso;

class AlumnoController extends Controller
{
    // Obtener todos los alumnos
    public function index()
    {
        return response()->json(Alumno::with('cursos')->get(), 200);
    }

    // Crear un nuevo alumno
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:alumnos',
            'telefono' => 'nullable|string|max:20'
        ]);

        $alumno = Alumno::create($request->all());

        return response()->json($alumno, 201);
    }

    // Obtener un alumno por ID
    public function show($id)
    {
        $alumno = Alumno::with('cursos')->find($id);
        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }

        return response()->json($alumno, 200);
    }

    // Actualizar un alumno
    public function update(Request $request, $id)
    {
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'string|max:255',
            'email' => 'email|unique:alumnos,email,' . $id,
            'telefono' => 'nullable|string|max:20'
        ]);

        $alumno->update($request->all());

        return response()->json($alumno, 200);
    }

    // Eliminar un alumno
    public function destroy($id)
    {
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }

        $alumno->delete();

        return response()->json(['message' => 'Alumno eliminado'], 200);
    }

    // Obtener los cursos de un alumno
    public function obtenerCursos($alumno_id)
    {
        $alumno = Alumno::with('cursos')->find($alumno_id);
        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }

        return response()->json($alumno->cursos, 200);
    }

    // Inscribir un alumno en un curso
    public function inscribirEnCurso($alumno_id, $curso_id)
    {
        $alumno = Alumno::findOrFail($alumno_id);
        $curso = Curso::findOrFail($curso_id);

        // Evitar duplicados
        if (!$alumno->cursos()->where('curso_id', $curso_id)->exists()) {
            $alumno->cursos()->attach($curso, ['fecha_inscripcion' => now()]);
            return response()->json(['message' => 'Alumno inscrito en el curso'], 200);
        } else {
            return response()->json(['message' => 'El alumno ya está inscrito en este curso'], 409);
        }
    }

    // Eliminar la inscripción de un alumno en un curso
    public function eliminarInscripcionCurso($alumno_id, $curso_id)
    {
        $alumno = Alumno::findOrFail($alumno_id);
        $curso = Curso::findOrFail($curso_id);

        if ($alumno->cursos()->where('curso_id', $curso_id)->exists()) {
            $alumno->cursos()->detach($curso);
            return response()->json(['message' => 'Alumno eliminado del curso'], 200);
        } else {
            return response()->json(['message' => 'El alumno no está inscrito en este curso'], 404);
        }
    }
}
