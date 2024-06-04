<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: '',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json(['error' => $e->getMessage(), 'code' => 404], 404);
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json(['error' => $e->getMessage(), 'code' => 422], 422);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json(['error' => $e->getMessage(), 'code' => 401], 401);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return response()->json(['error' => $e->getMessage(), 'code' => 405], 405);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            return response()->json(['error' => $e->getMessage(), 'code' => 403], 405);
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return response()->json(['error' => 'Cannot remove this resource permanently. It is related with any other resources', 'code' => 409], 409);
            }
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            return response()->json(['error' => $e->getMessage(), 'code' => 419], 419);
        });

        

    })->create();
