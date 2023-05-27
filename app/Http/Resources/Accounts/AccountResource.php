<?php

namespace App\Http\Resources\Accounts;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        $balance = 0.0;
        if($this->balance !== null){
            $balance = $this->balance;
        }
        $name = User::find($this->user_id)->name;
        return [
            'id' => $this->id,
            'account_number' => $this->account_number ,
            'user_id' => $this->user_id ,
            'user_name' => $name ,
            'balance' => $balance,
            'currency' => $this->currency,
            'country' => $this->country,
        ];
    }
}
