<?php

namespace App\Http\Controllers;


use App\Models\JobOpening;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobOpeningController extends Controller
{
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

        ]);

        $recruiter = Auth::user()->recruiter;

        if (!$recruiter) {
            return response()->json(['message' => 'Recrutador nao encontrado'], 404);
        }

        if (!$recruiter->company) {
            return response()->json(['message' => 'Recrutador precisa ter uma empresa para criar vagas'], 400);
        }
        $validateData['recruiter_id'] = $recruiter->id;

        $job = JobOpening::create($validateData);

        return response()->json([
            'message' => 'vaga criada com sucesso!',
            'vaga' => $job
        ]);
    }


    public function ShowRecrutador(Request $request, string $recrutadorId)
    {
        $user = Auth::user();

        if ($user->recruiter->id != $recrutadorId) {
            return response()->json(['error' => 'Você não tem permissão para visualizar estas vagas.'], 403);
        }

        $recruiter = $user->recruiter;
        $jobOpenings = $recruiter->jobOpenings;


        return response()->json([
            'vaga' => $jobOpenings,
        ]);

    }


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
        if (!$request->user()->tokenCan('edit-vaga')){
            return response()->json([
                'message' => 'sem permissão edit-vaga',

            ], 403);
        }
        if (Auth::user()->type !== 'recruiter') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }


        $recruiter = Auth::user()->recruiter;

        $datas = $request->validate([
            'title' =>'required|string|max:255',
            'description' =>'required|string|max:255',
            'salaries' =>'required|string|max:255',
            'categories' =>'required|string|max:255',
        ]);


        $job = JobOpening::findOrFail($id);

        if ($job->recruiter_id !== $recruiter->id) {
            return response()->json([
                'message' => 'Você não tem permissão para editar esta vaga.',
            ], 403);
        }

        $datas['recruiter_id'] = $recruiter->id;
        $job->update($datas);

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
        $job = JobOpening::find($id);
        if (!$job){
            response()->json([
                'message' => 'vaga nao encontrada',
            ], 404);
        }

        if ($job->recruiter_id !== Auth::user()->recruiter->id) {
            return response()->json([
                'message' => 'Você não tem permissão para editar esta vaga.',
            ], 403);
        }

        $job->delete();

        return response()->json([
            'message' => 'Vaga excluída com sucesso!',
        ], 200);
    }
}
