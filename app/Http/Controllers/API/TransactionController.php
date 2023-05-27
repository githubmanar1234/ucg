<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Http;
use Event;
use App\Events\SendMail;
use App\Http\Resources\Transactions\TransactionResource;
use App\Http\Resources\Transfers\TransferResource;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawRequest;
use App\Traits\TransactionTrait;

class TransactionController extends BaseController
{

    use TransactionTrait;

    //get transactions history by client
    public function get_my_transactions_history(){

        $user = Auth()->user();
        if($user->hasPermissionTo('get_transactions_history')){
            $transactions = $user->transactions;
            $transfers_from = $user->from_transfers;
            $transfers_to = $user->to_transfers;
    
            $data['transactions'] = TransactionResource::collection($transactions);
            $data['transfers_from'] = TransferResource::collection($transfers_from);
            $data['transfers_to'] = TransferResource::collection($transfers_to);
    
            return $this->sendResponse($data,'transactions history returned successfully.');
        }
        return $this->sendError('You do not have required permission.', ['error'=>'You do not have required permission']); 
    }

    //deposit by admin 
    public function deposit(DepositRequest $request)
    {
        $input = $request->all();
        if(Auth()->user()->hasPermissionTo('deposit')){
            $transaction = new Transaction();
            $transaction->amount   = $input['amount'];
            $transaction->type  = "deposit";
            $transaction->account_id   = $input['account_id'];
            $transaction->save();
           
            $account = Account::find($input['account_id']);
            $account->balance = $account->balance + $input['amount'];
            $account->save();
          
            return $this->sendResponse(new TransactionResource($transaction),'Transaction has craeted successfully.');
        }
        return $this->sendError('You do not have required permission.', ['error'=>'You do not have required permission']); 
    }

    //withdrawal by client
    public function withdrawal(WithdrawRequest $request)
    {
        $user_id = Auth()->user()->id;
        if(Auth()->user()->hasPermissionTo('withdrawal')){
            $input = $request->all();
            $account = Account::where('account_number',$input['account_number'])->first();
            $check_account = $this->check_account($input['account_number'],$user_id,$input['amount']);
            if($check_account){
                $transaction = new Transaction();
                $transaction->amount   = $input['amount'];
                $transaction->type  = "withdrawal";
                $transaction->account_id   = $account->id;
                $transaction->save();
    
                $account->balance = $current_balance - $input['amount'];
                $account->save();
    
                return $this->sendResponse(new TransactionResource($transaction),'Transaction has craeted successfully.');
    
            }
            else{
                return $this->sendError('This account not exist.', ['error'=>'This account not exist']); 
            }
        }
        return $this->sendError('You do not have required permission.', ['error'=>'You do not have required permission']); 
             
    }

  
}
