<?php

namespace App\Http\Resources\Transfers;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     
        return [
            'id' => $this->id,
            'from' => $this->from ,
            'to' => $this->to ,
            'amount' => $this->amount ,
        ];
    }
}
