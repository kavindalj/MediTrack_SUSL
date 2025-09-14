<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PharmacistOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has pharmacist role
        if (!auth()->check() || auth()->user()->role !== 'pharmacist') {
            // Redirect to dashboard with error message
            return redirect()->route('dashboard')->with('error', 'Access denied. This section is only available to pharmacists.');
        }

        return $next($request);
    }
}
