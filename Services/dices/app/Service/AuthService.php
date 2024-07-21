<?php
declare(strict_types=1);

namespace App\Service;

use App\Models\User;
use App\Models\Throws;

use Illuminate\Support\Facades\Hash;

use App\Exceptions\ThrowNotStoredInDBException;
use App\Exceptions\NoGamesStoredForUserInDBException;
use App\Exceptions\RegisterUserDataNotCorrectException;
use App\Exceptions\UserNotFoundByEmailException;
use App\Exceptions\NameAlreadyTakenException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\JWTokenNotGeneratedException;




class AuthService
{
	
	public function getRoleByUser(User $user): string
	{
		if($user->hasRole('admin'))
		{
			return 'admin';
		}else if($user->hasRole('player'))
		{	
			return 'player';
		}else{
			return 'none';
			//ToDo - Return Exception UserHasNoRoleException
		}
	}
	
	public function getUserByEmail(string $email): User
	{
		$user = User::where('email', $email)->first();
		
		if(!$user)
		{
			throw new UserNotFoundByEmailException($email);
		}
		
		return $user;
		
	}
	
	
	public function checkIfNameAllowed(?string $name = null): string
	{
		
		//Check if name is empty and add it as "Anonymous"
        if(!$name){
			$name = "Anonymous";
		}
		
		if(strtoupper($name) != 'ANONYMOUS'){
			//Check if name exists in database Users:
			$userSameName = User::where('name', $name)->first();
			//If it exists exit returning the code error 
			if($userSameName){
				throw new NameAlreadyTakenException($name);
			}
		}
		
		return $name;
	}
	
	public function checkUserCredentials(User $user, string $password): bool
	{
		if (!$user || !Hash::check($password, $user->password)) {
			throw new InvalidCredentialsException();
		}
		return true;
	}
	
	
	public function registerUser($registerData): User
	{
		if(!array_key_exists('name',$registerData) || !array_key_exists('email',$registerData) || !array_key_exists('password',$registerData))
		//if(!$registerData['name'] || !$registerData['email'] || !$registerData['password']  )
		{
			throw new RegisterUserDataNotCorrectException($registerData);
		}
		
        $registerData['password'] = bcrypt($registerData['password']);
        
        $user = User::create($registerData);
        
        if(!$user)
        {
			throw new UserNoCreatedException($data);
		}
        
        
        return $user;
	}
	
	public function addAdminRoleToUser(User $user): User
	{
		$user->assignRole('admin');
		return $user;;
	}
	
	public function addPlayerRoleToUser(User $user): User
	{
		$user->assignRole('player');
		return $user;
	}	
	
	public function removeAdminRoleToUser(User $user): User
	{
		$user->removeRole('admin');
		return $user;
	}
	
	public function removePlayerRoleToUser(User $user): User
	{
		$user->removeRole('player');
		return $user;
	}
	
	public function createJWTokenByUser(User $user): string
	{
		//Create the JWToken using passport which will be used by the user
        $JWToken = $user->createToken('API Token')->accessToken;
        
        if(!$JWToken){
			throw new JWTokenNotGeneratedException($user->id);
		}
        
        
        return $JWToken;
	}
	
	
	public function updateUserName(User $user, string $newName): User
	{
		$user->update(['name'=> $newName]);
		return $user;
	}
	
	
}
