<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
            $candidaturas = JobApplication::where('candidate_id', auth()->id())
            ->with('jobOpening')
            ->get();
            return response()->json([
                'candidaturas' => $candidaturas
            ]);
        }
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
        if (!$request->user()->tokenCan('Register-Candidate')){
            return response()->json([
                'message' => 'sem permição para registrar candidate'
            ]);
        }

        if (Auth::user()->type !== 'candidate'){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate ([
                'experiences' => 'required|string|max:255',
                'skills' => 'required|string|max:255',
                'CEP' => 'required|string|max:255',
                'house_number' => 'required|string|max:255',
        ]);

        $candidate = Candidates::where('user_id', Auth::id())->first();

        if ($candidate) {
            $candidate->update($data);
        } else {
            $data['user_id'] = Auth::id();
            $candidate = Candidates::create($data);
        }

        return response()->json([
            'message' => "candidato cadastrado com sucesso",
            'candidate' => $candidate,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
