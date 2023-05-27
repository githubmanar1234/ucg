<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\TransferController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Auth
Route::post('register', [AuthController::class, 'register']); 
Route::post('login', [AuthController::class, 'login']); 

//countries
Route::get('countries', [AccountController::class, 'get_all_countries']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    
    //accounts
    Route::post('account', [AccountController::class, 'create_account']); //admin
    Route::get('my_accounts', [AccountController::class, 'get_accounts_info']); //client
    Route::get('accounts', [AccountController::class, 'get_all_accounts']); //admin

    
    //transfers
    Route::post('transfer', [TransferController::class, 'transfer']); //client
    Route::get('transfers', [TransferController::class, 'get_all_transfers']); //admin

    //transactions
    Route::post('withdrawal', [TransactionController::class, 'withdrawal']); //client
    Route::post('deposit', [TransactionController::class, 'deposit']); //admin
    Route::get('transactions/history', [TransactionController::class, 'get_my_transactions_history']); //client
   
  });
