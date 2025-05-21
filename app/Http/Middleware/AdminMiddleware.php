<?php

namespace App\Http\Middleware;

use App\Http\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    use HttpResponse;

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === '1') {
            return $next($request);
        }

        return $this->unauthorizedAdmin();
    }
}
