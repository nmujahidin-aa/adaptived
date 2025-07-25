<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->namespace('App\\Http\\Controllers\\Auth')
                ->prefix('auth')
                ->as('auth.')
                ->group(base_path('routes/auth.php'));

            Route::middleware(['web', 'auth'])
                ->namespace('App\\Http\\Controllers\\Admin')
                ->prefix('admin')
                ->as('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\AuthenticatedMiddleware::class,
        ]);
        $middleware->web(append: [
        ]);
    })
    ->withExceptions(function ($exceptions) {
        // Tambahkan exception handler di sini jika perlu
    })
    ->create();
