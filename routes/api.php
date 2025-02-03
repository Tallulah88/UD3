<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\NotaController;

// Rutas de recursos REST
Route::apiResource('alumnos', AlumnoController::class);
Route::apiResource('profesores', ProfesorController::class)->parameters([
    'profesores' => 'profesor'
]);
Route::apiResource('asignaturas', AsignaturaController::class);
Route::apiResource('cursos', CursoController::class);
Route::apiResource('matriculas', MatriculaController::class);
Route::apiResource('notas', NotaController::class);

// 🔹 Relaciones entre alumnos y cursos
Route::get('alumnos/{alumno}/cursos', [AlumnoController::class, 'obtenerCursos']);
Route::post('alumnos/{alumno}/cursos/{curso}', [AlumnoController::class, 'inscribirEnCurso']);
Route::delete('alumnos/{alumno}/cursos/{curso}', [AlumnoController::class, 'eliminarInscripcionCurso']);

Route::get('cursos/{curso}/alumnos', [CursoController::class, 'obtenerAlumnos']);
Route::post('cursos/{curso}/alumnos/{alumno}', [CursoController::class, 'asignarAlumno']);
Route::delete('cursos/{curso}/alumnos/{alumno}', [CursoController::class, 'eliminarAlumno']);

// 🔹 Relaciones entre alumnos y asignaturas
Route::get('asignaturas/{asignatura}/alumnos', [AsignaturaController::class, 'obtenerAlumnos']);
Route::post('asignaturas/{asignatura}/alumnos/{alumno}', [AsignaturaController::class, 'inscribirAlumno']);
Route::delete('asignaturas/{asignatura}/alumnos/{alumno}', [AsignaturaController::class, 'eliminarInscripcionAlumno']);
