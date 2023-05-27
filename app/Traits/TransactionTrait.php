<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Account;
use Illuminate\Support\Facades\Http;


trait TransactionTrait {

    //check account to complete withdraw process
    public function check_account($account_number,$user_id,$amount){

        $account = Account::where('account_number',$account_number)->where('user_id',$user_id)->first();
        if($account){
            $current_balance = $account->balance;
            if($amount <= $current_balance){
                return true;
            }
        }
        return false;

    }

}