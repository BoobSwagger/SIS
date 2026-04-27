<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If they are not a student, kick them to the admin master list
        if (auth()->user()->role !== 'student') {
            return redirect('/students');
        }
        return $next($request);
    }
}
