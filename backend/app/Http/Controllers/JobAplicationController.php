<?php

namespace App\Http\Controllers;


use App\Models\JobOpening;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobAplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request): JsonResponse
    {
        if (Auth::user()->type !== 'recruiter') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validateData = $request->validate([
            'title' =>'required|string|max:255',
            'description' =>'required|string|max:255',
            'salaries' =>'required|string|max:255',
            'categories' =>'required|string|max:255',
            'publication_date' =>'required|date',
        ]);

        $recruiter = Auth::user()->recruiter;
        if (!$recruiter) {
            return response()->json(['message' => 'Recruiter not found'], 404);
        }
        $validateData['recruiter_id'] = $recruiter->id;

        $job = JobOpening::create($validateData);

        return response()->json([
            'message' => 'vaga criada com sucesso!',
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
    public function index(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $vagas = JobOpening::all();
        return response()->json([
            'vagas' => $vagas
        ]);
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
            'title' =>'required|string|max:255',
            'description' =>'required|string|max:255',
            'salaries' =>'required|string|max:255',
            'categories' =>'required|string|max:255',
            'publication_date' =>'required|date',
        ]);

        $job = JobOpening::findOrFail($id);

        $job->title = $request->title;
        $job->description = $request->description;
        $job->salaries = $request->salaries;
        $job->categories = $request->categories;
        $job->publication_date = $request->publication_date;

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
