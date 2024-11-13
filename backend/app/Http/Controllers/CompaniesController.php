<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
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


        if (!$request->user()->tokenCan('make-company')){


            return response()->json([
                'message' => 'sem permissão make-company',

            ]);
        }


        if (Auth::user()->type !== 'recruiter') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $companies = $request->validate ([
            'name' => 'required|string|max:255|unique:companies,name',
            'CNPJ' => 'required|string|max:255',
            'localization' => 'required|string|max:255',
        ]);

        $recruiter = Auth::user()->recruiter;
        if (!$recruiter) {
            return response()->json(['message' => 'Recruiter não encontrado'], 404);
        }
        $companies['recruiter_id'] = $recruiter->id;

        $companie = Companies::create($companies);

        $recruiter->company_id = $companie->id;
        $recruiter->save();

        return response()->json([
            'message' => 'empresa cadastrada com sucesso',
            'empresa' => $companie,
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
