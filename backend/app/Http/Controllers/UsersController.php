<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'type' =>'required|in:' . User::TYPE_RECRUITER . ',' . User::TYPE_CANDIDATE,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type
        ]);

        if ($user->type == User::TYPE_RECRUITER) {

            Recruiter::create([
                'user_id' => $user->id
            ]);

            $token = $user->createToken('recruiterToken',['create-vaga', 'view-vagas', 'edit-vaga', 'make-company'])->plainTextToken;

        } else if ($user->type == User::TYPE_CANDIDATE) {

            Candidates::create([
                'user_id' => $user->id
            ]);

            $token = $user->createToken('candidateToken', ['view-vagas'])->plainTextToken;
        }

        return response()->json([
            'message' => 'usuario registrado com sucessoo!',
            'usuario' => $user,
            'token' => $token
        ]);

    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->type === User::TYPE_RECRUITER){

                $token = $user->createToken('recruiterToken',['create-vaga', 'view-vagas', 'edit-vaga', 'make-company'])->plainTextToken;

            } else if ($user->type === User::TYPE_CANDIDATE) {

                $token = $user->createToken('candidateToken', ['view-vagas', 'apply-vagas', 'Register-Candidate'])->plainTextToken;

            } else {
                return response()->json(['ERROR, Type nao encontrado']);
            }

            return response()->json([

                'token'=> $token,
                'user' => $user
        ]);
    }

        return response()->json ([
            'error' => 'credencais invalidas'
        ]);
}

public function getUserData(string $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'error' => 'Usuário não encontrado',
        ], 404);
    }


    if ($user->type == User::TYPE_RECRUITER) {
        $recruiterData = $user->recruiter()->with('company')->first();
        return response()->json([
            'user' => $user,
            'recruiter' => $recruiterData,
        ]);
    }

    if ($user->type == User::TYPE_CANDIDATE) {
        $candidateData = $user->candidate;
        return response()->json([
            'user' => $user,
            'candidate' => $candidateData,
        ]);
    }

    return response()->json([
        'error' => 'Tipo de usuário não encontrado',
    ], 404);
}
}
