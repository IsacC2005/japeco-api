<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\InscripciModel;
use Illuminate\Http\Request;

class InscripciController extends Controller
{
    public function index()
    {
        $students = InscripciModel::get();

        return response()->json([
            'data' => $students ? StudentResource::collection($students) : [],
            'status' => 'success',
            'message' => "Estos son todos los estudiantes ;)"
        ], 202);
    }
}
