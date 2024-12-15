<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next): Response{

       if ($request->session()->get('authenticated',false) === true){
           return $next($request);
       }
       $request->session()->forget('authenticated');
       $request->session()->forget('user');
       return redirect('login')->with('error', 'Your session has expired.');
    }
}