<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::get('/client/{clientId}', [ClientsController::class, 'getAllAccounts']);
    Route::get('/accounts/{accountId}/{offset}/{limit}', [TransactionsController::class, 'getTransactionHistory']);
    Route::post('/accounts/transfer', [TransactionsController::class, 'transferMoney']);
});
