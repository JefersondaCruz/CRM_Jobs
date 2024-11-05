<?php

use App\Http\Controllers\JobAplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UsersController::class, 'register']);

Route::post('/login', [UsersController::class, 'login']);

Route::middleware('auth:sanctum')->post('/vagas', [JobAplicationController::class, 'index']);

Route::middleware('auth:sanctum')->put('/vagas/{id}', [JobAplicationController::class, 'update']);



