<?php

namespace App\Middlewares;

use System\Http\Request;
use System\Http\Response;

class AppMiddleware
{
    public function handle(Request $request, \Closure $next): Response
    {
        // do your stuff
        return $next($request);
    }
}
