<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
     public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->position == "employee"){
                return $next($request);
            }
            else {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }
        }
        // User has not login
        else {
            
        }

        return $next($request);
    }
}