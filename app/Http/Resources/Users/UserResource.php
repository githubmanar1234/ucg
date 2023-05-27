<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $token =  $this->createToken('MyApp')->plainTextToken;

        return [
            'id' => $this->id,
            'name' => $this->name ,
            'email' => $this->email ,
            'token' => $token ,
        ];
    }
}
