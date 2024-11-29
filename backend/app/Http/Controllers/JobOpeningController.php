<?php

namespace App\Http\Controllers;


use App\Models\JobApplication;
use App\Models\JobOpening;
use App\Models\Recruiter;
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

        if ($user->id != $recrutadorId) {
            return response()->json(['error' => 'Você não tem permissão para visualizar estas vagas.'], 403);
        }

        $recruiter = $user->recruiter;
        $jobOpenings = $recruiter->jobOpenings;


        return response()->json([
            'vaga' => $jobOpenings,
        ]);
    }

    public function ShowVaga (Request $request, string $vagaId)
    {
        $user = Auth::user();
        $vaga = JobOpening::where('id', $vagaId)
        ->whereHas('recruiter', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->first();

        if (!$vaga) {
            return response()->json(['error' => 'Vaga não encontrada ou você não tem permissão para visualizá-la.'], 403);
        }
        return response()->json(['vaga' => $vaga]);

    }

    public function show()
    {
        $vagas = JobOpening::all();
        return response()->json([
            'vagas' => $vagas
        ]);
    }

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

    public function UpdateStatus(Request $request, string $jobApplicationId )
    {
        $data = $request->validate([
            'status' => 'required|in:' . JobApplication::STATUS_PENDING . ',' . JobApplication::STATUS_APPROVED . ',' . JobApplication::STATUS_REJECTED,
        ]);

        $jobApplication = JobApplication::find($jobApplicationId);

        if (!$jobApplication) {
            return response()->json(['error' => 'Vaga aplicada não encontrada'], 404);
        }

        $jobOpening = JobOpening::find($jobApplication->job_opening_id);

        if (!$jobOpening) {
            return response()->json(['error' => 'Vaga não encontrada'], 404);
        }

        $recruiter = Recruiter::where('user_id', auth()->id())->first();

        if (!$recruiter || $recruiter->id !== $jobOpening->recruiter_id) {
            return response()->json(['error' => 'Permissão negada'], 403);
        }

        $jobApplication->status = $data['status'];
        $jobApplication->save();

        return response()->json([
            'message' => 'Status da vaga  atualizado com sucesso!',
            'jobApplication' => $jobApplication,
        ], 200);
    }
}
