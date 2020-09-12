<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $view = (in_route('dashboard') ? 'dashboard' : 'blog').'.error';

        if (($code = $e->getStatusCode()) === 404) {
            $message = 'The page you where looking for was not found.';
        } else {
            $message = 'Oops, something went wrong.';
        }

        return response()->view(
            $view,
            compact('code', 'message'),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }
}
