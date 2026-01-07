<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // Corrected Import
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // CENTRAL Admin Routes
            Route::middleware('web')
                ->prefix('control')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Correctly type-hint Illuminate\Http\Request
        $exceptions->render(function (AuthenticationException $e, Request $request) {

            // 1. Check if the URL starts with /control
            // 2. Check if the 'admin' guard was actually used in the exception
            if ($request->is('control') || $request->is('control/*') || in_array('admin', $e->guards())) {
                return redirect()->route('admin.login');
            }

            return null; // Default behavior for others (redirects to /login)
        });
    })->create();
