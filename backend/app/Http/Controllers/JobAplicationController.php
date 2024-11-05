<?php

namespace App\Http\Controllers;

use App\Models\job_application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobAplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        if (Auth::user()->type !== 'recruiter') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $jobs = $request->validate([
            'job_title' =>'required|string|max:255',
            'description' =>'required|string|max:255',
            'salary' =>'required|string|max:255',
            'location' =>'required|string|max:255',
            'company_id' =>'required|string|max:255',
            'status' =>'required|string|max:255',
        ]);

        $job = job_application::create($jobs);

        return response()->json([
            'message' => 'vaga registrada com sucessoo!',
            'vaga' => $job
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->type !== 'recruiter') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'job_title' =>'required|string|max:255',
            'description' =>'required|string|max:255',
            'salary' =>'required|string|max:255',
            'location' =>'required|string|max:255',
            'company_id' =>'required|string|max:255',
            'status' =>'required|string|max:255',
        ]);

        $job = job_application::findOrFail($id);

        $job->job_title = $request->job_title;
        $job->description = $request->description;
        $job->salary = $request->salary;
        $job->location = $request->location;
        $job->company_id = $request->company_id;
        $job->status = $request->status;

        $job->save();

        return response()->json([
            'message' => 'vaga atualizada com sucesso!',
            'vaga' => $job
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
