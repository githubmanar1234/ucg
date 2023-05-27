<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest{
    public function rules():array
    {
        return [
            'amount' => 'required',
            'account_number' => 'required', 
        ];
    }
}





?>