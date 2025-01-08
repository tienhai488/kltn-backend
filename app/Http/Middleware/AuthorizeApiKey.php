<?php

namespace App\Http\Middleware;

use App\Responses\JsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->apiKey = $request->header('API-KEY');

        if ($this->apiKey === null || !$this->isValidApiKey($this->apiKey)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Không được phép: Cung cấp khóa API không hợp lệ.',
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        if (!request()->expectsJson()) {
            return response()->json([
                'message' => 'Không được phép: Cung cấp khóa API không hợp lệ.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    /**
     * Validate the api key to the env api key
     *
     * @param String $apiKey
     * @return boolean
     */
    private function isValidApiKey($apiKey)
    {
        if ($apiKey !== config('app.api_key')) {
            return false;
        }
        return true;
    }
}
