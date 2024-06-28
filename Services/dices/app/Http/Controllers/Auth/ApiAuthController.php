<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;

class ApiAuthController extends Controller
{
    //From Here To End Copy And Paste From Following Source:
    //https://blog.logrocket.com/laravel-passport-a-tutorial-and-example-build/
    //No my code... but checked and "improved"... with some notes
    
    //Changed name from register to store
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
		
		//bcrypt -> php function to hash a given text using... a hard hashing algorithm one direction
        $data['password'] = bcrypt($request->password);
		//Create the user in the database
        $user = User::create($data);
        //Add role to user:
        $user->assignRole('player');
		//Create the token which will be used by the user
        $token = $user->createToken('API Token')->accessToken;

        //return response([ 'user' => $user, 'token' => $token], 201);
        return response()->json([ 'user' => $user, 'token' => $token], 201);
    }
    
    
    //Changed name from register to store
    public function registerAdmin(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
		
		//bcrypt -> php function to hash a given text using... a hard hashing algorithm one direction
        $data['password'] = bcrypt($request->password);
		//Create the user in the database
        $user = User::create($data);
        //Add role to user:
        $user->assignRole('admin');
		//Create the token which will be used by the user
        $token = $user->createToken('API Token')->accessToken;

        //return response([ 'user' => $user, 'token' => $token], 201);
        return response()->json([ 'user' => $user, 'token' => $token], 201);
    }
    

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
		
		//If authentication not succesfull respond with an error message
        if (!auth()->attempt($data)) {
            return response()->json(['error_message' => 'Incorrect Details. 
            Please try again'], 401);
        }
		
		//If authentication successfull create a token for the user
        $token = auth()->user()->createToken('API Token')->accessToken;
		//Return the user name with the generated token
		//ToDo For Api - Add type of user (Admin/Player)
        return response()->json(['user' => auth()->user(), 'token' => $token], 200);

    }
    
    //ToDo - Version 2 - Logout function in order to delete token...
    
}
