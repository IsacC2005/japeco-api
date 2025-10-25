<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeacherResource;
use App\Models\PersoModel;
use Illuminate\Http\Request;

class PersoController extends Controller
{
    public function getAllTeacher()
    {
        $teachers = PersoModel::where('funcionp', 'DOCENTE')->get();

        return response()->json([
            'data' => TeacherResource::collection($teachers),
            'status' => 'success',
            'message' => 'Lista de Docentes Recuperada Exitosamente'
        ], 200);
    }

    public function existTeacher(int $id)
    {
        $teacher = PersoModel::where('id', $id)->where('funcionp', 'DOCENTE')->exists();

        return response()->json([
            'data' => $teacher,
            'status' => 'success',
            'message' => 'Profesor Encontrado'
        ], 220);
    }

    public function showTeacher(int $id)
    {
        $teacher = PersoModel::where('id', $id)->where('funcionp', 'DOCENTE')->first();

        if (!$teacher) {
            return response()->json([
                'data' => [],
                'status' => 'success',
                'message' => 'Profesor No Encontrado'
            ], 404);
        }

        return response()->json([
            'data' => new TeacherResource($teacher),
            'status' => 'success',
            'message' => 'Profesor Encontrado'
        ], 220);
    }
}
