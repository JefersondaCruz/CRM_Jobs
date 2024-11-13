<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function applyToJob(Request $request)
    {
        $user = Auth::user();
        if ($user->type !== 'candidate') {
            return response()->json(['message' => 'Somento Candidatos podem aderir a vaga']);
        }


        $request->validate([
            'job_opening_id' => 'required|exists:jobOpenings,id',
        ]);

        $existingApplication = JobApplication::where('job_opening_id', $request->job_opening_id)
        ->where('candidate_id', $user->id)
        ->first();

        if ($existingApplication) {
            return response()->json(['message' => 'Você já aplicou para esta vaga'], 400);
        }

        $application = JobApplication::create([
            'job_opening_id' => $request->job_opening_id,
            'candidate_id' => $user->id,
            'status' => 'pending',


        ]);
        return response()->json([
            'message' => 'Você aplicou para esta vaga com sucesso!',
            'application' => $application
        ]);
    }
}
