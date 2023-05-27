<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest{
    public function rules():array
    {
        return [
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required',
        ];
    }
}





?>