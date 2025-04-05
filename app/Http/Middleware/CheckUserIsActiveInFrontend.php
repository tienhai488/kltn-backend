<?php

namespace App\Http\Middleware;

use App\Enum\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsActiveInFrontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status != UserStatus::ACTIVE) {
            $request->bearerToken() ?
                auth()->user()->tokens()->delete()
                : auth()->logout();

            return response()->json(['message' => 'Tài khoản của bạn đã không hoạt động.'], 403);
        }

        return $next($request);
    }
}
