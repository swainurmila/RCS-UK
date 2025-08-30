<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('ammendment')
                ->middleware('web')
                ->group(base_path('routes/ammendment.php'));
            Route::prefix('complaint')
                ->middleware('web')
                ->group(base_path('routes/complaint.php'));
            Route::prefix('inspection')
                ->middleware('web')
                ->group(base_path('routes/inspection.php'));
                 Route::prefix('election')
                ->middleware('web')
                ->group(base_path('routes/election.php'));
            Route::prefix('audit')
                ->middleware('web')
                ->group(base_path('routes/audit.php'));
            Route::prefix('settlement')
                ->middleware('web')
                ->group(base_path('routes/settlement.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\LanguageMiddleware::class,
            \App\Http\Middleware\RedirectIfAuthenticatedWithRole::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();