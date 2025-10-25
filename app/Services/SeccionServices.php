<?php

namespace App\Services;

use App\Http\Resources\SeccionDetailResource;
use App\Http\Resources\SeccionResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentToEscolariResource;
use App\Http\Resources\TeacherResource;
use App\Models\EscolariEstuModel;
use App\Models\PersoModel;
use App\Models\SeccionModel;

class SeccionServices
{

    public function getAllSeccionsDetails()
    {
        $sectionsModel = SeccionModel::get();

        $sectionsData = []; // SeccionDetailResource::collection($sectionModels);

        foreach ($sectionsModel as $section) {
            $data = (new SeccionDetailResource($section))->toArray(request());


            if (!isset($data['teacher'])) {
                $data['teacher'] = [];
            }

            $idcard = is_numeric($section->cedudoc) ? (int)$section->cedudoc : 0;
            $teacher = $this->getTeacher($idcard);

            $data['teacher'][] = $teacher;

            if (!isset($data['students'])) {
                $data['students'] = [];
            }

            $students = $this->getStudentsBySection($section->escolari, $section->codigo, $section->numero);

            $data['students'] = $students;

            $sectionsData[] = $data;
        }

        return $sectionsData;
    }


    //

    public function getAllSeccionDetailsToSchoolYear(string $schoolYear)
    {
        $sectionsModel = SeccionModel::where('escolari', $schoolYear)->get();

        $sectionsData = [];

        foreach ($sectionsModel as $section) {
            $data = (new SeccionDetailResource($section))->toArray(request());


            if (!isset($data['teacher'])) {
                $data['teacher'] = [];
            }

            $idcard = is_numeric($section->cedudoc) ? (int)$section->cedudoc : 0;
            $teacher = $this->getTeacher($idcard);

            $data['teacher'][] = $teacher;

            if (!isset($data['students'])) {
                $data['students'] = [];
            }

            $students = $this->getStudentsBySection($section->escolari, $section->codigo, $section->numero);

            $data['students'] = $students;

            $sectionsData[] = $data;
        }

        return $sectionsData;
    }


    public function getAllSeccionDetailsToSchoolYearByTeacher(string $schoolYear, int $teacherId)
    {

        $teacher = PersoModel::where('id', $teacherId)->where('funcionp', 'DOCENTE')->first();

        if (!$teacher) {
            return null;
        }

        $section = SeccionModel::where('escolari', $schoolYear)
            ->where('cedudoc', $teacher->cedula)->first();

        $sectionsData = [];

        $data = (new SeccionDetailResource($section))->toArray(request());


        if (!isset($data['teacher'])) {
            $data['teacher'] = [];
        }

        $idcard = is_numeric($section->cedudoc) ? (int)$section->cedudoc : 0;
        $teacher = $this->getTeacher($idcard);

        $data['teacher'][] = $teacher;

        if (!isset($data['students'])) {
            $data['students'] = [];
        }

        $students = $this->getStudentsBySection($section->escolari, $section->codigo, $section->numero);

        $data['students'] = $students;

        $sectionsData[] = $data;

        return $sectionsData;
    }


    // TODO: Funciones privadas

    private function getTeacher(int $idcard)
    {
        $teacher = PersoModel::where('cedula', $idcard)->first();

        if (!$teacher) {
            return [];
        }

        return new TeacherResource($teacher);
    }

    private function getStudentsBySection($schoolYear, $grade, $section)
    {
        $data = EscolariEstuModel::with('estudiante')
            ->where('escolari_estu.aescolar', $schoolYear)
            ->where('escolari_estu.grado', $grade)
            ->where('escolari_estu.seccion', $section)
            ->get();

        return StudentToEscolariResource::collection($data);
    }
}
