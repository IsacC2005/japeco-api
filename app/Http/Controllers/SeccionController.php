<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeccionDetailResource;
use App\Http\Resources\SeccionResource;
use App\Http\Resources\TeacherResource;
use App\Models\PersoModel;
use App\Models\SeccionModel;
use App\Services\SeccionServices;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class SeccionController extends Controller
{

    public function __construct(
        private SeccionServices $services
    ) {}

    public function find(int $id)
    {
        $section = SeccionModel::find($id);

        if (!$section) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Seccion no encontrada'
            ], 404);
        }

        return response()->json([
            'data' => new SeccionResource($section),
            'status' => 'success',
            'message' => 'Seccion encontrada'
        ], 220);
    }

    //? devuelve las secciones a las que se a asignado un profesor
    public function findByTeacher(int $id)
    {
        $teacher = PersoModel::find($id);

        if (!$teacher) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profesor no encontrado'
            ], 404);
        }
        $sections = SeccionModel::where('cedudoc', $teacher->cedula)->get();

        $data = [];

        foreach ($sections as $section) {
            $sectionData = (new SeccionDetailResource($section))->toArray(request());
            $sectionData['teaccher'] = [];
            $sectionData['teacher'][] = new TeacherResource($teacher);

            $data[] = $sectionData;
        }

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Estas son todas las secciones'
        ], 220);
    }



    public function TeacherItsAssingToSecction(Request $request)
    {
        $validated = $request->validate([
            'enrollmentId' => 'required|numeric',
            'teacherId' => 'required|numeric',
        ]);
        $enrollmentId = $validated['enrollmentId'];
        $teacherId = $validated['teacherId'];

        $teacher = PersoModel::find($teacherId);

        if (!$teacher) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profesor no encontrado'
            ], 404);
        }


        $result = SeccionModel::where('id', $enrollmentId)
            ->where('cedudoc', $teacher->cedula)
            ->exists();

        return response()->json([
            'data' => $result,
            'status' => 'success'
        ], 202);
    }



    //? Devuelve todas las secciones
    public function getAllSeccion()
    {
        $sections = SeccionModel::get();

        return response()->json([
            'data' => SeccionResource::collection($sections),
            'status' => 'success',
            'message' => 'Estas son todas las secciones'
        ], 220);
    }


    //? Devuelve todas las secciones, con los datos del profesor y los estudiantes
    public function getAllSeccionsDetails()
    {
        $sections = $this->services->getAllSeccionsDetails();

        return response()->json([
            'data' => $sections,
            'status' => 'success',
            'message' => 'Estas son las secciones detalladas'
        ], 220);
    }



    // ?Devuelve todas las secciones de un Ciclo escolar especifico
    public function getAllSeccionToSchoolYear(Request $response)
    {
        $schoolYear = $response->input('school-year');

        $sections = SeccionModel::where('escolari', $schoolYear)->get();

        return response()->json([
            'data' => SeccionResource::collection($sections),
            'status' => 'sucess',
            'message' => "Estas son todas las seccion del periodo escolar $schoolYear"
        ], 200);
    }

    // ?Devuelve todas las secciones de un Ciclo escolar especifico
    public function getAllSeccionDetailsToSchoolYear(Request $response)
    {
        $schoolYear = $response->input('schoolYear');
        $sections = $this->services->getAllSeccionDetailsToSchoolYear($schoolYear);

        return response()->json([
            'data' => $sections,
            'status' => 'success',
            'message' => 'Estas son las secciones detalladas'
        ], 220);
    }


    // ?Devuelve la seccion de un Ciclo escolar especifico de un profesor especifico
    public function getAllSeccionDetailsToSchoolYearByTeacher(Request $response)
    {
        $schoolYear = $response->input('schoolYear');
        $teacherId = $response->input('teacherId');
        $sections = $this->services->getAllSeccionDetailsToSchoolYearByTeacher($schoolYear, $teacherId);

        return response()->json([
            'data' => $sections,
            'status' => 'success',
            'message' => 'Estas son las secciones detalladas'
        ], 220);
    }


    public function findBySchoolYearByTeacher(Request $response)
    {

        $validated = $response->validate([
            'schoolYear' => 'required|string|min:9|max:9',
            'teacherId' => 'required|numeric'
        ]);

        $schoolYear = $response->input('schoolYear');
        $teacherId = $response->input('teacherId');

        $teacher = PersoModel::select('cedula')
            ->where('id', $teacherId)
            ->where('tipop', 'DOCENTE')
            ->first();

        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Profesor no encontrado'
            ], 404);
        }

        $section = SeccionModel::select('id', 'codigo', 'numero', 'aula', 'nombre', 'escolari')
            ->where('escolari', $schoolYear)
            ->where('cedudoc', $teacher->cedula)
            ->first();

        return response()->json([
            'data' => $section ? new SeccionResource($section) : null,
            'status' => 'success',
            'message' => 'Seccion'
        ], 202);
    }
}
