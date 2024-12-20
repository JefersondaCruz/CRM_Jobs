<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CandidateController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $candidate = $user->candidate;

        if (!$candidate) {
            return response()->json(['message' => 'Você não tem um cadastro de candidato associado.'], 400);
        }

            $candidaturas = JobApplication::where('candidate_id',  $candidate->id)
            ->with('jobOpening')
            ->get();

            return response()->json([
                'candidaturas' => $candidaturas
            ]);
    }
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
                'phone' => 'required|string|max:255',
                'social_media' => 'required|string|max:255',
                'CEP' => 'required|string|max:255',
                'house_number' => 'required|string|max:255',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'about' => 'required|string|max:255',
        ]);

        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $imagePath;
        }

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

    public function updateProfilePicture(Request $request, $userId)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $candidate = Candidates::where('user_id', $userId)->first();

        if (!$candidate) {
            return response()->json(['error' => 'Candidato não encontrado'], 404);
        }

        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');

            $candidate->profile_picture = $imagePath;
            $candidate->save();

            $imagePath = asset('storage/' . $candidate->profile_picture);
            return response()->json([
                'message' => 'Foto de perfil do candidato atualizada com sucesso!',
                'profile_picture' =>  $imagePath,
            ]);
        }

        return response()->json(['error' => 'Nenhuma imagem foi enviada'], 400);
    }
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'experiences' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'social_media' => 'nullable|string|max:255',
            'CEP' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'about' => 'nullable|string|max:255',
        ]);

        $candidate = Candidates::where('user_id', Auth::id())->first();

        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado'], 404);
        }

        $candidate->update($data);

        return response()->json([
            'message' => 'Perfil atualizado com sucesso!',
            'candidate' => $candidate,
        ]);
    }
}
