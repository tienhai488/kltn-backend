<?php

namespace App\Http\Middleware;

use App\Enum\NotificationType;
use App\Enum\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->status->value === UserStatus::LOCKED->value) {
                auth()->logout();
                session()->flash(
                    NotificationType::NOTIFICATION_ERROR->value,
                    __('Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên để được hỗ trợ.')
                );
                return to_route('auth.login.show-form');
            }
        }

        return $next($request);
    }
}
