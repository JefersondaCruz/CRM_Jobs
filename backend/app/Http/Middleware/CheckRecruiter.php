<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class CheckRecruiter
{
    public function handle(Request $request, Closure $next)
    {
        
        if (! $request->user()->tokenCan('create-vaga')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
