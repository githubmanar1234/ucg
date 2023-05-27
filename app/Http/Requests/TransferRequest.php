<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest{
    public function rules():array
    {
        return [
            'amount' => 'required',
            'from' => 'required|exists:accounts,id',
            'to' => 'required|exists:accounts,id', 
        ];
    }
}





?>