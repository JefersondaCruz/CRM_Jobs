<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Companies;

use Illuminate\Http\Request;

class CompaniesController extends Controller
{

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

    public function updateCompany(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'CNPJ' => 'required|string|max:255',
            'localization' => 'required|string|max:255',
        ]);

        $recruiter = Auth::user()->recruiter;

        if(!$recruiter) {
            return response()->json([
                'message' => 'Recruiter não encontrado'
            ], 404);
        }

        $companie = Companies::find($recruiter->company_id);

        if (!$companie){
            return response()->json([
                'message' => 'companie nao encontrada'
            ], 404);
        }

        $companie->update($data);

        return response()->json ([
            'message' => 'companie atualizada com sucesso',
            'companie' => $companie
        ]);
    }
}
