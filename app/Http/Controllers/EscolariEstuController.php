<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\EscolariEstuModel;
use App\Models\SeccionModel;
use Illuminate\Http\Request;

class EscolariEstuController extends Controller
{
    public function getAllStudentBySection(int $id)
    {
        $sectionModel = SeccionModel::find($id);

        $schoolYear = $sectionModel->escolari;
        $grade = $sectionModel->codigo;
        $section = $sectionModel->numero;

        $students  = EscolariEstuModel::where('aescolar', $schoolYear)
            ->where('grado', $grade)
            ->where('seccion', $section)->get();

        return response()->json([
            'data' => $students ? StudentResource::collection($students) : [],
            'status' => 'success',
            'message' => "Estos son los estudiantes de la seccion $id"
        ], 202);
    }
}
