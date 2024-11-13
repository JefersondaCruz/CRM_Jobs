<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\JobOpeningController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);

Route::middleware(['auth:sanctum', 'check.recruiter'])->put('/vagas/{id}', [JobOpeningController::class, 'update']);
Route::middleware(['auth:sanctum','check.recruiter'])->delete('/vagas/{id}', [JobOpeningController::class, 'destroy']);
Route::middleware(['auth:sanctum','check.recruiter'])->post('/vagas', [JobOpeningController::class, 'store']);
# Route::middleware(['auth:sanctum','check.candidate'])->get('/vagas', [JobOpeningController::class, 'index']);





Route::get('/vagas', [JobOpeningController::class, 'show']);


Route::middleware(['auth:sanctum','check.recruiter'])->post('/companies', [CompaniesController::class, 'store']);





