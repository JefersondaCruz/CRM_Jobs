<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\JobOpeningController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user/{id}', [UsersController::class, 'getUserData']);

Route::prefix('user')->group(function (){
    Route::post('/register', [UsersController::class, 'register']);
    Route::post('/login', [UsersController::class, 'login']);
});

Route::prefix('Recruiter')->middleware(['auth:sanctum', 'check.recruiter'])->group(function (){
    Route::put('/vagas/{id}', [JobOpeningController::class, 'update']);
    Route::delete('/vagas/{id}', [JobOpeningController::class, 'destroy']);
    Route::post('/vagas', [JobOpeningController::class, 'store']);
    Route::get('/vagas/recrutador/{id}', [JobOpeningController::class, 'showRecrutador']);
    Route::get('/vagas/select/{id}',[JobOpeningController::class, 'ShowVaga']);
    Route::post('/companies', [CompaniesController::class, 'store']);
    Route::get('/vagas/{id}/applications', [JobApplicationController::class, 'viewJobApplications']);
    Route::put('/vagas/{id}/status', [JobOpeningController::class, 'updateStatus']);
    Route::put('/companie/update-company',[CompaniesController::class, 'updateCompany']);
});
Route::get('/vagas', [JobOpeningController::class, 'show']);

Route::prefix('Candidate')->middleware(['auth:sanctum', 'check.candidate'])->group(function (){
    Route::post('/vagas/candidatar/{id}',[JobApplicationController::class, 'applyToJob']);
    Route::post('/details/candidate', [CandidateController::class, 'store']);
    Route::get('/applications', [CandidateController::class, 'index']);
    Route::post('/profile/{userId}/update-picture', [CandidateController::class, 'updateProfilePicture']);
    Route::put('/profile/update-profile', [CandidateController::class, 'updateProfile']);
});





