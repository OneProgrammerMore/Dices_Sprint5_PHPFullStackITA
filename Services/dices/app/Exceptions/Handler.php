<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;

use App\Exceptions\{
	ThrowNotStoredInDBException,
	NoGamesStoredForUserInDBException,
	UserNotFoundByEmailException,
	NameAlreadyTakenException,
	InvalidCredentialsException,
	NoGamesStoredInDBException,
	RegisterUserDataNotCorrectException,
	JWTokenNotGeneratedException
    };



//GameService:
//PlayerService:


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
        
		$this->renderable(function (ThrowNotStoredInDBException $e, Request $request) {
			//return response()->view('errors.invalid-order', [], 500);
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		});
		
		$this->renderable(function (NoGamesStoredForUserInDBException $e, Request $request) {
			//return response()->view('errors.invalid-order', [], 500);
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		});
		$this->renderable(function (NoGamesStoredInDBException $e, Request $request) {
			//return response()->view('errors.invalid-order', [], 500);
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		});
		$this->renderable(function (UserNotFoundByEmailException $e, Request $request) {
			//return response()->view('errors.invalid-order', [], 500);
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		});
		$this->renderable(function (NameAlreadyTakenException $e, Request $request) {
			//return response()->view('errors.invalid-order', [], 500);
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		});
		
		
		$this->renderable(function (InvalidCredentialsException $e, Request $request) {
			//return response()->view('errors.invalid-order', [], 500);
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		});
		
		$this->renderable(function (RegisterUserDataNotCorrectException $e, Request $request) {
			//return response()->view('errors.invalid-order', [], 500);
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		});
		
		$this->renderable(function (JWTokenNotGeneratedException $e, Request $request) {
			//return response()->view('errors.invalid-order', [], 500);
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		});
		
        
        
    }
}
