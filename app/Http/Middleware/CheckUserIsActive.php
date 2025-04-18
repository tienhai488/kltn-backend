<?php

namespace App\Http\Middleware;

use App\Enum\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->status != UserStatus::ACTIVE) {
            auth()->logout();

            return to_route('auth.login.show_form');
        }

        return $next($request);
    }
}
