<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest{
    public function rules():array
    {
        return [
            'name' => 'required|string|min:2|max:32',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ];
    }
}





?>