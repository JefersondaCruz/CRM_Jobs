<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCandidate
{
    public function handle(Request $request, Closure $next)
    {

        $requiredPermissions = ['view-vagas', 'apply-vagas','Register-Candidate'];

        foreach ($requiredPermissions as $permission) {
            if (!$request->user()->tokenCan($permission)) {
                return response()->json(['message' => 'Forbidden Candidate'], 403);
            }
        }
        return $next($request);
    }
}
