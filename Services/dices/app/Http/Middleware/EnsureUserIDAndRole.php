<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIDAndRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {	
		
		//First if the user role is admin do not check anything and NEXT!!!
		if(Auth::user()->hasRole('admin')){
			
			return $next($request);
		
		}elseif(Auth::user()->hasRole('player')){
			
			$playerIDRoute = $request->route('player_id');
			//$playerIDAuth = auth('api')->user();
			$playerIDAuth = Auth::user()->id;
			
			if($playerIDRoute != null){
				//If the authenticate player is not the player for the route:
				//Return error 401
				if($playerIDRoute != $playerIDAuth ){
					return response()->json(['error' =>  'User Error'], 401);
				}
			}else{
				//Dunno what happened here, player id not existing or no parameter
				return response()->json(['error' => 'URL Error'], 404);
			}
			
			return $next($request);
	
		}else{
			//Okay something happened here... And I dunno what...
			//No role assigned of the allowed
			//Return error to avoid hacking intrussions
			//ToDo - Log The error
			return response()->json(['error' => 'URL Error'], 404);
		}
		
    }
}
