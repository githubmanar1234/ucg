<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Account;
use Illuminate\Support\Facades\Http;


trait AccountTrait {

    //check unique account in one country
    public function isExist_account() 
    {
        
        
    }

    //get currency by country
    public function get_currency_by_country($country_name){

        $response = Http::get('https://restcountries.com/v3/name/'. urlencode($country_name) .'?fields=currencies');
        
        $data = json_decode($response, true);

        $firstCurrency = reset($data[0]['currencies']); // Get the first element of the "currencies" object
        $firstName = $firstCurrency['name'];
        return $firstName;

    }

    public function isInviteNumberExists($number)
    {
        $inviteNumber = Account::where('account_number', '=', $number)->first();

       if ($inviteNumber === null)
       {
           return false;
       }
       else
       {
           return true;
       }
    }

    // Make random account_number from 6 digits
    public function generateAccount_number() 
    {
                // 10  random charts
                $result = '';
                for ($i = 0; $i < 10; $i++) {
                    $result .= chr(rand(65, 90));
                }
                
            
                // Call the same function if exists already
                if ($this->isInviteNumberExists( $result)) {
                    return $this->generateAccount_number();
                }
            
                // otherwise, it's valid and can be used
                return $result;
    }

}