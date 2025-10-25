<?php

use App\Http\Controllers\EscolariEstuController;
use App\Http\Controllers\InscripciController;
use App\Http\Controllers\PersoController;
use App\Http\Controllers\SeccionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/teacher/index', [PersoController::class, 'getAllTeacher']);
Route::get('/teacher/show/{id}', [PersoController::class, 'showTeacher']);
Route::get('/teacher/exist/{id}', [PersoController::class, 'existTeacher']);



Route::get('/section/index', [SeccionController::class, 'getAllSeccion']);
Route::get('/section/show/{id}', [SeccionController::class, 'find']);
Route::get('/section/details', [SeccionController::class, 'getAllSeccionsDetails']);
Route::get('/section/school-year/details', [SeccionController::class, 'getAllSeccionDetailsToSchoolYear']);
Route::get('/section/assings-teacher/{id}', [SeccionController::class, 'findByTeacher']);
Route::get('/section/teacher-if-assing', [SeccionController::class, 'TeacherItsAssingToSecction']);

Route::get('/sections/school-year', [SeccionController::class, 'getAllSeccionToSchoolYear']);
Route::get('/section/find/school-year-and-teacher-id', [SeccionController::class, 'findBySchoolYearByTeacher']);

Route::get('/student/index', [InscripciController::class, 'index']);
Route::get('/student/to-section/{id}', [EscolariEstuController::class, 'getAllStudentBySection']);

Route::get('/test-conection', function () {
    return response()->json([
        'data' => true,
        'status' => 'success',
        'message' => 'Conexion exitosa'
    ], 200);
});
