<?php


use \Exception as Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;     
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function(AccessDeniedHttpException $exception, Request $request) {
            return response()->json(['mensagem' => 'Não autorizado'], 403);
        });

        $exceptions->render(function(AuthenticationException $exception, Request $request) {
            return response()->json(['mensagem' => 'Não autenticado - token inválido'], 403);
        });

        $exceptions->render(function(NotFoundHttpException $exception, Request $request) {
            return response()->json(['mensagem' => 'Não encontrado'], 404);
        });

        $exceptions->render(function(ValidationException $exception, Request $request) {
            return response()->json($exception->errors(), 422);
        });

        $exceptions->render(function(Exception $exception, Request $request) {
            return response()->json([
                'mensagem' => $exception->getMessage(),
                'class' => get_class($exception),
                'file' => 'app.php',
            ], 500);
        });
    })->create();
