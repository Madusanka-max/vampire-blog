<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEditor
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        
        if (!$user || !($user->hasRole('admin') || $user->hasRole('editor'))) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}