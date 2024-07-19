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
		}
		
		if(Auth::user()->hasRole('player')){
			
			$userIDRoute = $request->route('user')->id;
			$userIDAuth = Auth::user()->id;
			
			if(!$userIDRoute || !$userIDAuth)
			{
				return response()->json(['error' =>  'User Error'], 404);
			}
			if($userIDRoute != $userIDAuth)
			{
				return response()->json(['error' => 'URL Error'], 401);
			}
						
			return $next($request);
	
		}

		return response()->json(['error' => 'URL Error'], 404);
		
    }
}
