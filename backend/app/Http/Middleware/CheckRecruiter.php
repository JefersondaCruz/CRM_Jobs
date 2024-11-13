<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class CheckRecruiter
{
    public function handle(Request $request, Closure $next)
    {

        $requiredPermissions = ['create-vaga', 'view-vagas', 'edit-vaga', 'make-company'];

        foreach ($requiredPermissions as $permission) {
            if (!$request->user()->tokenCan($permission)) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        }
        return $next($request);
    }
}
