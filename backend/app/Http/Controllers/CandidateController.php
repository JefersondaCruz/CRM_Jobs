<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $candidate = Auth::user()->candidate;

        if (!$candidate) {
            return response()->json(['message' => 'candidate não encontrado'], 404);
        }


        $data['user_id'] = Auth::user()->id;

        $candidateDetails = Candidates::create($data);

        return response()->json([
            'message' => 'candidato cadastrada com sucesso',
            'candidate' => $candidateDetails,
        ]);
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
