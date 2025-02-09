<?php

namespace App\Exceptions;

use App\Acl\Acl;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponses;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // if (($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException || $exception instanceof MethodNotAllowedHttpException)) {
        //     if ($request->is(config('subdomain.docs') . '.*') || $request->getHost() === config('subdomain.docs') . '.' . parse_url(config('app.url'), PHP_URL_HOST)) {
        //         return redirect()->to('/v1');
        //     } elseif ($request->getHost() === config('subdomain.api') . '.' . parse_url(config('app.url'), PHP_URL_HOST)) {
        //         return $this->notFoundResponse();
        //     } elseif (! $request->expectsJson()) {
        //         $redirectName = null;
        //         if (auth()->check()) {
        //             if (auth()->user()->hasAnyRole([Acl::ROLE_SUPER_ADMIN, Acl::ROLE_ADMIN])) {
        //                 $redirectName = 'admin.dashboard';
        //             }

        //             if (auth()->user()->hasRole(Acl::ROLE_SUPERVISOR)) {
        //                 $redirectName = 'supervisor.dashboard';
        //             }

        //             if (auth()->user()->hasRole(Acl::ROLE_STAFF)) {
        //                 $redirectName = 'staff.dashboard';
        //             }
        //         } else {
        //             $redirectName = 'auth.login.show-form';
        //         }

        //         if (isset($redirectName) && $redirectName) {
        //             return to_route($redirectName);
        //         }
        //     }
        // } elseif ($request->getHost() === config('subdomain.api') . '.' . parse_url(config('app.url'), PHP_URL_HOST)) {
        //     if ($exception instanceof ValidationException) {
        //         return $this->unprocessableResponse($exception->errors());
        //     } elseif ($exception instanceof AuthorizationException || $exception instanceof UnauthorizedException) {
        //         return $this->forbiddenResponse();
        //     } elseif ($exception instanceof AuthenticationException) {
        //         return $this->unauthorizedResponse();
        //     }
        // }

        return parent::render($request, $exception);
    }
}