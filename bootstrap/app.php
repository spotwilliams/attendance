<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware (previously $middleware in Http/Kernel.php)
        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Cat\Http\Middleware\InputTrim::class,
        ]);

        // Web group middleware (previously $middlewareGroups['web'] in Http/Kernel.php)
        $middleware->web(replace: [
            \Cat\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Cat\Http\Middleware\VerifyCsrfToken::class,
        ]);

        // Middleware aliases (previously $middlewareAliases in Http/Kernel.php)
        $middleware->alias([
            'auth'       => \Cat\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'can'        => \Illuminate\Foundation\Http\Middleware\Authorize::class,
            'guest'      => \Cat\Http\Middleware\RedirectIfAuthenticated::class,
            'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Don't report these (previously $dontReport in Exceptions/Handler.php)
        $exceptions->dontReport([
            AuthorizationException::class,
            \Illuminate\Database\Eloquent\ModelNotFoundException::class,
            \Illuminate\Validation\ValidationException::class,
        ]);

        // Custom render logic (previously Handler::render)
        $exceptions->render(function (\Throwable $e, $request) {
            if ($e instanceof TokenMismatchException) {
                return response(view('errors.expired'), 500);
            }
            if ($e instanceof MethodNotAllowedHttpException) {
                return response(view('errors.http'), 500);
            }
            if ($e instanceof AuthorizationException) {
                if ($request->ajax()) {
                    return response()->json(['message' => 'No tiene permisos para ejecutar'], 403);
                }
                return response(view('errors.403'));
            }
            if ($e instanceof NotFoundHttpException) {
                return response(view('errors.404'), 404);
            }

            if (! config('app.debug')) {
                return response(view('errors.unknown'));
            }
        });
    })->create();
