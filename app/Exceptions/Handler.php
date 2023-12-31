<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use HttpResponses;
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
        $this->renderable(function (NotFoundHttpException $e, Request $request) {

            // dd($e->getMessage());
            if ($request->is('api/*')) {
                return $this->error($e->getMessage(), $e->getStatusCode());
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {

            if ($request->is('api/*')) {
                return $this->error($e->getMessage(), $e->getStatusCode());
            }
        });

        $this->renderable(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return $this->error($e->getMessage(), $e->getStatusCode());
            }
        });
        
    }
}
