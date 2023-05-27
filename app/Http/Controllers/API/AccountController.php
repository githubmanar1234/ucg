<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Http;
use Event;
use App\Events\SendMail;
use App\Traits\AccountTrait;
use App\Http\Resources\Accounts\AccountResource;
use App\Http\Requests\CreateAccountRequest;

class AccountController extends BaseController
{
    use AccountTrait;

    //get list of countries 
    public function get_all_countries(){

        $response = Http::get('https://restcountries.com/v3/all?fields=name,currencies');
        
        $jsonData = $response->json();

        $countries = [];
        foreach($jsonData as $country){
          
            $name = $country['name']['common'];
            
            $countries[] = $name;
        }
        return $this->sendResponse($countries,'countries returned successfully.');


    }

    //create account by admin
    public function create_account(CreateAccountRequest $request)
    {
        if(Auth()->user()->hasPermissionTo('create_account')){
            $input = $request->all();
            // Six digits random number
            $account_number = sprintf("%06d", mt_rand(1, 999999));
    
            // Call the same function if exists already
            if ($this->isInviteNumberExists($account_number)) {
                return $this->generateAccount_number();
            }
            $user = User::find($input['user_id']);
            if(!$user->is_exist_account($input['country'])){
                $account = new Account();
                $account->account_number   = $account_number;
                $account->user_id  = $input['user_id'];
                $account->currency  = $this->get_currency_by_country($input['country']);
                $account->country  = $input['country'];
                $account->save();
        
                //send account info to user
                Event(new SendMail($input['user_id']));
               
                return $this->sendResponse(new AccountResource($account),'Account has created successfully.');
            }    
            else{
                return $this->sendError('This account already exist.', ['error'=>'This account already exist']); 
            }
        }
        return $this->sendError('You do not have required permission.', ['error'=>'You do not have required permission']); 
        
    }

    //get accounts info by client
    public function get_accounts_info()
    {
        $user = Auth()->user();
        if($user->hasPermissionTo('get_accounts_info')){
            $accounts = $user->accounts;
            return $this->sendResponse(AccountResource::collection($accounts),'accounts has returned successfully.');
        }
        return $this->sendError('You do not have required permission.', ['error'=>'You do not have required permission']); 
        
    }

    //get all accounts by admin
    public function get_all_accounts(){

        $user = Auth()->user();
        if($user->hasPermissionTo('get_all_accounts')){
            $accounts = Account::all();
            return $this->sendResponse(AccountResource::collection($accounts),'accounts has returned successfully.');
        }
        return $this->sendError('You do not have required permission.', ['error'=>'You do not have required permission']); 
        
    }
  
}
