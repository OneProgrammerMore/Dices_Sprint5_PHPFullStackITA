<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

// App\Http\Middleware\EnsureUserID
class EnsureUserID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $playerIDRoute = $request->route('player_id');
        //$playerIDAuth = auth('api')->user();
        $playerIDAuth =Auth::user()->id;
        
        if($playerIDRoute != null){
			//If the authenticate player is not the player for the route:
			//Return error 401
			if($playerIDRoute != $playerIDAuth ){
				//return response(['error' =>  'User Error'], 401);
				return response()->json(['error' =>  'User Error'], 401);
			}
		}else{
			//Dunno what happened here, player id not existing or no parameter
			//return response(['error' => 'URL Error'], 404);
			return response()->json(['error' => 'URL Error'], 404);
		
		}

        return $next($request);
    }
}
