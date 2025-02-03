<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;

class NotaController extends Controller
{
    public function index()
    {
        return response()->json(Nota::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'calificacion' => 'required|integer|min:0|max:10'
        ]);

        $nota = Nota::create($request->all());

        return response()->json($nota, 201);
    }
}
