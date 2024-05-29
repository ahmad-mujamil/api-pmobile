<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MyScrambleMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if(Gate::has('viewApiDocs'))
            return $next($request);

        abort(403, 'Unauthorized action.');
    }
}
