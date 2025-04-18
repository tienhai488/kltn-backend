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
                $redirectName = 'admin.dashboard.index';
            } else if (auth()->user()->hasAnyRole([Acl::ROLE_ORGANIZATION, Acl::ROLE_INDIVIDUAL]) && ! Route::is(['member.*'])) {
                $redirectName = 'member.dashboard.index';
            }
        } else {
            $redirectName = 'auth.login.show_form';
        }

        if (!empty($redirectName)) {
            return to_route($redirectName);
        }

        return $next($request);
    }
}