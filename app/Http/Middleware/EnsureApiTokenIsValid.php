<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiTokenIsValid
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->bearerToken() || $request->bearerToken() !== config('kanye.api_token')) {
            return \App\Http\Response::error(
                message: 'Unauthorized',
                status: 401
            );
        }
        return $next($request);
    }
}
