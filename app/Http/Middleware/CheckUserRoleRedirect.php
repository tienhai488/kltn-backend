<?php

namespace App\Http\Middleware;

use App\Acl\Acl;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $redirectName = null;
        if (auth()->check()) {
            if (auth()->user()->hasAnyRole([Acl::ROLE_SUPER_ADMIN, Acl::ROLE_ADMIN]) && ! Route::is(['admin.*'])) {
                $redirectName = 'admin.dashboard';
            }

            if (auth()->user()->hasRole(Acl::ROLE_SUPERVISOR) && ! Route::is(['supervisor.*'])) {
                if (!$redirectName) {
                    $redirectName = 'supervisor.dashboard';
                }
            }

            if (auth()->user()->hasRole(Acl::ROLE_STAFF) && ! Route::is(['staff.*'])) {
                if ($redirectName) {
                    $redirectName = 'staff.dashboard';
                }
            }
        } else {
            $redirectName = 'auth.login.show-form';
        }

        if (isset($redirectName) && $redirectName) {
            return to_route($redirectName);
        }

        return $next($request);
    }
}
