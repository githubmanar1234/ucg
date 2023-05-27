<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Account;
use Illuminate\Support\Facades\Http;


trait TransferTrait {

    //check accounts to complete transfer process
    public function check_accounts($from_account_id,$to_account_id,$amount,$user_id){

        $from_account = Account::where('id',$from_account_id)->where('user_id',$user_id)->first();
       
        $to_account = Account::where('id',$to_account_id)->first();

        if($from_account && $from_account_id !== $to_account_id){
            if($from_account->country == $to_account->country){ //These accounts not in the same country
                if($amount <= $from_account->balance){ //Your wallet not enough
                     return true;
                }
            }
        }
        return false;

    }

}