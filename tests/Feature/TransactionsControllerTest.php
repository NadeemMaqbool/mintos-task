<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Account;
use App\Enum\CurrencyEnum;
use Illuminate\Support\Str;
use App\Enum\AccountTypesEnum;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionsControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
       parent::setUp();

       $this->seed(DatabaseSeeder::class);
    }

    public function test_transfer_money_from_account_to_account() 
    {
        $accountId1 = Account::where('client_id', 'AB23454565')->where('currency', 'USD')->first();
        $accountId2 = Account::where('client_id', 'DH34454096')->where('currency', 'EUR')->first();
        
        $response = $this->post('/api/v1/accounts/transfer', [
            'senderAccountId' => $accountId1->account_id,
            'receiverAccountId' => $accountId2->account_id,
            'amount' => 30,
            'currency' => 'EUR'
        ]);
        
        $data = json_decode($response->getContent(), true);
        $response->assertStatus(201);
        
        $this->assertSame('Transaction completed successfully', $data["message"]);
    }
    
    public function test_transaction_fail_validations(): void
    {
        $response = $this->post('/api/v1/accounts/transfer', [
           // 'senderAccountId' => 'byMF6Ovwx7',
            'receiverAccountId' => 'uOBj4ptg7P',
            'amount' => 30,
            'currency' => 'USD'
        ]);
        
        $response->assertStatus(400);
    }

    public function test_account_id_does_not_exist() 
    {
        $response = $this->post('/api/v1/accounts/transfer', [
            'senderAccountId' => 'byMF6Ovwx7001',
            'receiverAccountId' => 'uOBj4ptg7P',
            'amount' => 30,
            'currency' => 'USD'
        ]);
        
        $data = json_decode($response->getContent(), true);
        $response->assertStatus(400);
        
        $this->assertSame('Error: Account id does not exist', $data["message"]);
    }

    public function test_requested_currency_type_matches_receiver_currency_type() 
    {
        $accountId1 = Account::where('client_id', 'AB23454565')->where('currency', 'USD')->first();
        $accountId2 = Account::where('client_id', 'DH34454096')->where('currency', 'EUR')->first();
        
        $response = $this->post('/api/v1/accounts/transfer', [
            'senderAccountId' => $accountId1->account_id,
            'receiverAccountId' => $accountId2->account_id,
            'amount' => 30,
            'currency' => 'USD'
        ]);
        
        $data = json_decode($response->getContent(), true);
        $response->assertStatus(400);
        
        $this->assertSame('Error: Requested currency does not match with receiver account', $data["message"]);
    }

    public function test_client_account_does_not_have_enough_balance() 
    {
        $accountId1 = Account::where('client_id', 'AB23454565')->where('currency', 'EUR')->first();
        $accountId2 = Account::where('client_id', 'FF00110010')->where('currency', 'GBP')->first();
        
        $response = $this->post('/api/v1/accounts/transfer', [
            'senderAccountId' => $accountId2->account_id,
            'receiverAccountId' => $accountId1->account_id,
            'amount' => 10,
            'currency' => 'EUR'
        ]);
        
        $data = json_decode($response->getContent(), true);
        $response->assertStatus(400);

        $this->assertSame('Error: Transaction failed as sender account does not have enough balance', $data["message"]);
    }

}
