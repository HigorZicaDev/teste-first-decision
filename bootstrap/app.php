<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            $envelope = fn (string $message, mixed $errors, int $status) => response()->json([
                'data' => null,
                'message' => $message,
                'errors' => $errors,
            ], $status);

            if ($e instanceof ValidationException) {
                return $envelope('Os dados informados são inválidos.', $e->errors(), 422);
            }

            if ($e instanceof AuthenticationException) {
                return $envelope('Não autenticado.', null, 401);
            }

            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                return $envelope('Recurso não encontrado.', null, 404);
            }

            if ($e instanceof HttpException) {
                return $envelope($e->getMessage() ?: 'Erro na requisição.', null, $e->getStatusCode());
            }

            return null;
        });
    })->create();
