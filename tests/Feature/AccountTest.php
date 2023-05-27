<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Account;

class AccountTest extends TestCase
{
 
    use  RefreshDatabase;
    
    public function it_can_get_all_accounts_with_specific_columns()
    {
        // create some accounts
        $accounts = \App\Models\Account::factory()->count(5)->create();

        // define the columns we want to retrieve
        $columns = [
            'account_number',
            'user_id',
            'balance',
            'currency',
            'country',
        ];

        // make a GET request to the accounts index route with the selected columns
        $response = $this->get(route('accounts', ['columns' => $columns]));

        // assert that the response has a successful status code
        $response->assertStatus(200);

        // assert that the response contains all of the accounts created with the specified columns
        foreach ($accounts as $account) {
            $response->assertJsonFragment([
                'account_number' => $account->account_number,
                'user_id' => $account->user_id,
                'balance' => $account->balance,
                'currency' => $account->currency,
                'country' => $account->country,
            ]);
        }
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
