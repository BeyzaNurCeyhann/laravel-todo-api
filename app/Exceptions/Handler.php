<?php

namespace App\Exceptions;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException as LaravelValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof LaravelValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doğrulama hatası',
                'errors' => $exception->errors(),
            ], 422);
        }


        if ($exception instanceof ApiException) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
                'errors' => $exception->getErrors(),
            ], $exception->getStatusCode());
        }

    
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => 'error',
                'message' => 'İstenen kaynak bulunamadı.',
            ], 404);
        }


        return response()->json([
            'status' => 'error',
            'message' => 'Beklenmeyen bir hata oluştu.',
            'errors' => [
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
            ]
        ], 500);
    }
}
