<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignatura;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Alumno;

class AsignaturaController extends Controller
{
    // Obtener todas las asignaturas con relaciones
    public function index()
    {
        return response()->json(Asignatura::with(['profesor', 'curso', 'alumnos'])->get(), 200);
    }

    // Crear una nueva asignatura
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'profesor_id' => 'required|exists:profesores,id',
            'curso_id' => 'required|exists:cursos,id'
        ]);

        $asignatura = Asignatura::create($request->all());

        return response()->json($asignatura, 201);
    }

    // Obtener una asignatura por ID con sus relaciones
    public function show($id)
    {
        $asignatura = Asignatura::with(['profesor', 'curso', 'alumnos'])->find($id);
        if (!$asignatura) {
            return response()->json(['message' => 'Asignatura no encontrada'], 404);
        }

        return response()->json($asignatura, 200);
    }

    // Actualizar una asignatura
    public function update(Request $request, $id)
    {
        $asignatura = Asignatura::find($id);
        if (!$asignatura) {
            return response()->json(['message' => 'Asignatura no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'string|max:255',
            'profesor_id' => 'exists:profesores,id',
            'curso_id' => 'exists:cursos,id'
        ]);

        $asignatura->update($request->all());

        return response()->json($asignatura, 200);
    }

    // Eliminar una asignatura
    public function destroy($id)
    {
        $asignatura = Asignatura::find($id);
        if (!$asignatura) {
            return response()->json(['message' => 'Asignatura no encontrada'], 404);
        }

        $asignatura->delete();

        return response()->json(['message' => 'Asignatura eliminada'], 200);
    }

    // Obtener los alumnos inscritos en una asignatura
    public function obtenerAlumnos($id)
    {
        $asignatura = Asignatura::with('alumnos')->find($id);
        if (!$asignatura) {
            return response()->json(['message' => 'Asignatura no encontrada'], 404);
        }

        return response()->json($asignatura->alumnos, 200);
    }

    // Inscribir un alumno en una asignatura
    public function inscribirAlumno($asignatura_id, $alumno_id)
    {
        $asignatura = Asignatura::findOrFail($asignatura_id);
        $alumno = Alumno::findOrFail($alumno_id);

        // Evitar duplicados
        if (!$asignatura->alumnos()->where('alumno_id', $alumno_id)->exists()) {
            $asignatura->alumnos()->attach($alumno);
            return response()->json(['message' => 'Alumno inscrito en la asignatura'], 200);
        } else {
            return response()->json(['message' => 'El alumno ya está inscrito en esta asignatura'], 409);
        }
    }

    // Eliminar la inscripción de un alumno en una asignatura
    public function eliminarInscripcionAlumno($asignatura_id, $alumno_id)
    {
        $asignatura = Asignatura::findOrFail($asignatura_id);
        $alumno = Alumno::findOrFail($alumno_id);

        if ($asignatura->alumnos()->where('alumno_id', $alumno_id)->exists()) {
            $asignatura->alumnos()->detach($alumno);
            return response()->json(['message' => 'Alumno eliminado de la asignatura'], 200);
        } else {
            return response()->json(['message' => 'El alumno no está inscrito en esta asignatura'], 404);
        }
    }
}
