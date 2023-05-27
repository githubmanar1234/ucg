<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

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
        $this->renderable(function (UnauthorizedException $exception, $request) {
            if ($exception instanceof UnauthorizedException) {
               
                return response()->json([
                    'success' => false,
                    'data'    =>(object)[],
                    'status_code' => 403,
                    'errors' => [
                        'You do not have required permission.',
                    ],
                ]);
                
            }
            return parent::render($request, $exception);
        
        });

        $this->reportable(function (Throwable $e) {
            //
        });

        
    }

    

}
