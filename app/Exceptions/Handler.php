<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
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

        // Handle HTTP exceptions
        $this->renderable(function (HttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'status' => $e->getStatusCode()
                ], $e->getStatusCode());
            }

            // Handle specific HTTP status codes
            switch ($e->getStatusCode()) {
                case 403:
                    return response()->view('errors.403', [], 403);
                case 404:
                    return response()->view('errors.404', [], 404);
                case 419:
                    return response()->view('errors.419', [], 419);
                case 429:
                    return response()->view('errors.429', [], 429);
                case 500:
                    return response()->view('errors.500', [], 500);
                case 503:
                    return response()->view('errors.503', [], 503);
                default:
                    return response()->view('errors.generic', [
                        'statusCode' => $e->getStatusCode(),
                        'message' => $e->getMessage()
                    ], $e->getStatusCode());
            }
        });
    }
}
