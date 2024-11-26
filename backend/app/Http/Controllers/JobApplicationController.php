<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;
use App\Models\User;

class JobApplicationController extends Controller
{
    public function applyToJob(Request $request, string $id)
    {
        $user = Auth::user();
        if ($user->type !== User::TYPE_CANDIDATE) {
            return response()->json(['message' => 'Somento Candidatos podem aderir a vaga']);
        }

        $jobOpeningId = $id;

        $existingApplication = JobApplication::where('job_opening_id', $jobOpeningId)
        ->where('candidate_id', $user->id)
        ->first();

        if ($existingApplication) {
            return response()->json(['message' => 'Você já aplicou para esta vaga'], 400);
        }

        $application = JobApplication::create([
            'job_opening_id' => $id,
            'candidate_id' => $user->id,
            'status' => JobApplication::STATUS_PENDING,


        ]);
        return response()->json([
            'message' => 'Você aplicou para esta vaga com sucesso!',
            'application' => $application
        ]);
    }

    public function viewJobApplications (Request $request, $jobOpeningId)
    {
        $user = Auth::user();


        if ($user->type !== User::TYPE_RECRUITER) {
            return response()->json(['message' => 'Apenas recrutadores podem visualizar candidaturas'], 403);
        }

        $recruiter = $user->recruiter;

        $jobOpening = $recruiter->jobOpenings()->find($jobOpeningId);

        if (!$jobOpening) {
            return response()->json(['message' => 'Vaga não encontrada ou você não tem permissão para visualizá-la'], 404);
        }

        $applications = $jobOpening->applications()->with('candidate')->get();

        return response()->json([
            'message' => 'Candidaturas recuperadas com sucesso',
            'applications' => $applications,
        ]);
    }
}
