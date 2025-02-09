<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Scramble::ignoreDefaultRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::macro('isWith', function (...$parameters) {
            foreach ($parameters as $parameter) {
                if (
                    url()->current() == (!is_array($parameter)
                        ? route($parameter)
                        : route($parameter[0], $parameter[1] ?? []))
                ) {
                    return true;
                }
            }
            return false;
        });

        Scramble::registerApi('docs', [
            'api_path' => 'api/v1',
        ])
            ->routes(function (RoutingRoute $route) {
                return Str::startsWith($route->uri, 'api/v1');
            })
            ->afterOpenApiGenerated(function (OpenApi $openApi) {
                $openApi->secure(
                    SecurityScheme::http('bearer')
                );
            });
    }
}