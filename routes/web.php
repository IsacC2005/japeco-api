<?php

use App\Http\Controllers\PersoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
