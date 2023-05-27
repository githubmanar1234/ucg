<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\Users\UserResource;
use Validator;

class AuthController extends BaseController
{
    /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */
    public function register(CreateUserRequest $request)
    {
       $input = $request->all();
       $input['password'] = bcrypt($input['password']);
       $user = User::create($input);
       return $this->sendResponse(new UserResource($user), 'User has registered successfully.');
    }
  
    /**
        * Login api
        *
        * @return \Illuminate\Http\Response
        */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
    
            return $this->sendResponse(new UserResource($user), 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
