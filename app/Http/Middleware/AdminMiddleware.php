<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();

            if ($user->hasRole('admin')) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized from admin middleware'], 401);
    }
}
