<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest{
    public function rules():array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'country' => 'required|string',
        ];
    }
}





?>