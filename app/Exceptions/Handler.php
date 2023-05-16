<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {   //add Accept: application/json in request
            return $this->handleException($request, $exception);
        } else {
            return parent::render($request, $exception);
        }
    }

    public function handleException($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the request is invalid', 405);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified URL cannot be found', 404);
        }
        if ($exception instanceof RouteNotFoundException) {
            return $this->errorResponse('The specified Route cannot be found', 404);
        }
        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        
        if ($exception instanceof ValidationException) {
            return $this->errorResponse($exception->validator->errors(), 400);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse('Unauthenticated', 403);
        }
        if ($exception instanceof ModelNotFoundException){
            return $this->errorResponse('The specified data cannot be found', 404);
        }
        if ($exception instanceof AuthorizationException){
            return $this->errorResponse('This action is unauthorized', 403);
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);            
        }
    
        return $this->errorResponse('Unexpected Exception. Try later '.get_class($exception), 500);

    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
    return response()->json(['error' => 'Unauthenticated.'], 401);
    }
}
