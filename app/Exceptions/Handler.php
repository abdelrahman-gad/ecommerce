<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
            
            if($e instanceof \Illuminate\Validation\ValidationException){
                return response()->json([
                    'status'=>false,
                    'message'=>'Validation error',
                    'data'=>$e->errors()
                ],422);
            }

            if($e instanceof \Illuminate\Auth\Access\AuthorizationException){
                return response()->json([
                    'status'=>false,
                    'message'=>'Authorization error',
                    'data'=>[]
                ],403);
            }

            if($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException){
                return response()->json([
                    'status'=>false,
                    'message'=>'Model not found',
                    'data'=>[]
                ],404);
            }

          // MissingScopeExceprion sanctum
          if($e instanceof \Laravel\Sanctum\Exceptions\MissingAbilityException){
            
            return response()->json([
                'status'=>false,
                'message'=>'Missing scope',
                'data'=>[]
            ],403);
          }
    });
 }
}
