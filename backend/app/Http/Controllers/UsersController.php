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
        } else if ($user->type == User::TYPE_CANDIDATE) {

            Candidates::create([
                'user_id' => $user->id
            ]);
        }

        return response()->json([
            'message' => 'usuario registrado com sucessoo!',
            'usuario' => $user
        ]);

    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->type === 'recruiter'){

                $token = $user->createToken('recruiterToken',['create-vaga', 'view-vagas', 'edit-vaga', 'make-company'])->plainTextToken;

            } else if ($user->type === 'candidate') {

                $token = $user->createToken('candidateToken', ['view-vagas'])->plainTextToken;

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
