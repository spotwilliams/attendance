<?php

namespace Cat\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport
        = [
            AuthorizationException::class,
            HttpException::class,
            ModelNotFoundException::class,
            ValidationException::class,
        ];
    
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(\Throwable $e)
    {
        parent::report($e);
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $e
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, \Throwable $e)
    {
        if ($e instanceof TokenMismatchException) {
            return response(view('errors.expired'), 500);
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            return response(view('errors.http'), 500);
        }
        if ($e instanceof AuthorizationException) {
            if ($request->ajax()) {
                return Response::json([
                    'message' => 'No tiene permisos para ejecutar',
                
                ], 403);
                
                
            } else {
                return response(view('errors.403'));
            }
            
        }
        if ($e instanceof NotFoundHttpException) {
            return response(view('errors.404'));
        }
        
        $return = parent::render($request, $e);
        
        if($return instanceof RedirectResponse) {
            return $return;
        }

        if (config('app.debug')) {
            return parent::render($request, $e);

        }

        return response(view('errors.unknown'));
    }
}
