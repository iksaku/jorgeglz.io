<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function renderHttpException(HttpExceptionInterface $e)
    {
        if (Str::contains(Route::getCurrentRoute()->getPrefix(), 'dashboard')) {
            $view = 'dashboard.error';
        } else {
            $view = 'blog.error';
        }

        return response()->view($view, [
            'errors' => new ViewErrorBag(),
            'exception' => $e,
        ], $e->getStatusCode(), $e->getHeaders());
    }
}
