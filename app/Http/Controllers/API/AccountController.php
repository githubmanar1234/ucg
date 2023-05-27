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

    public function __construct()
    {
        $this->middleware(['permission:create_account'],['only' => ['create_account']]);
        $this->middleware(['permission:get_accounts_info'],['only' => ['get_accounts_info']]);
        $this->middleware(['permission:get_all_accounts'],['only' => ['get_all_accounts']]);
    }


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

    //get accounts info by client
    public function get_accounts_info()
    {
        $user = Auth()->user();
        $accounts = $user->accounts;
        return $this->sendResponse(AccountResource::collection($accounts),'accounts has returned successfully.');
    }

    //get all accounts by admin
    public function get_all_accounts(){

        $accounts = Account::all();
        return $this->sendResponse(AccountResource::collection($accounts),'accounts has returned successfully.');
    }
  
}
