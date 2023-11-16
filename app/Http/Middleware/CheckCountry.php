<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //only make accesible to users from Ecuador and Venezuela
        $country = ['Ecuador', 'Venezuela'];
        if (!in_array($request->country, $country)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
        
    }
}
