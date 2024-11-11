<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCandidate
{
    public function handle(Request $request, Closure $next)
    {
        
        if (! $request->user()->tokenCan('view-vagas')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}