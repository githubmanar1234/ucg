<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Transfer;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Transfers\TransferResource;
use App\Http\Requests\TransferRequest;
use App\Traits\TransferTrait;

class TransferController extends BaseController
{
    use TransferTrait;

    public function __construct()
    {
        $this->middleware(['permission:transfer'],['only' => ['transfer']]);
        $this->middleware(['permission:get_all_transfers'],['only' => ['get_all_transfers']]);
    }

    //transfer from account to another in same country
    public function transfer(TransferRequest $request)
    {
        $user_id = Auth()->user()->id;
        $input = $request->all();
        $check_accounts = $this->check_accounts($input['from'],$input['to'],$input['amount'],$user_id);
        if($check_accounts){
            $transfer = new Transfer();
            $transfer->from = $input['from'];
            $transfer->to = $input['to'];
            $transfer->amount = $input['amount'];
            $transfer->save();

            return $this->sendResponse(new TransferResource($transfer),'transfer created successfully.');  
        }
        else{
            return $this->sendError('You cannt transfer from this account.', ['error'=>'You cannt transfer from this account']); 
        }
    }

    //get all transfers between all accounts
    public function get_all_transfers(){

        $transfers = Transfer::all();
        return $this->sendResponse(TransferResource::collection($transfers),'transfers has returned successfully.');
    }

  
}
