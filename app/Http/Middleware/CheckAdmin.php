<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If they are not an admin, kick them to the student portal
        if (auth()->user()->role !== 'admin') {
            return redirect('/student/portal');
        }
        return $next($request);
    }
}
