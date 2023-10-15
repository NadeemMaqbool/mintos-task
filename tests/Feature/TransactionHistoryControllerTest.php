<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Account;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionHistoryControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

       $this->seed(DatabaseSeeder::class);
    }
    
    public function test_transaction_history_fails_validation(): void
    {
        $response = $this->get('/api/v1/transactions');

        $response->assertStatus(400);
    }

    public function test_get_account_transaction_history() 
    {
        $accountId1 = Account::where('client_id', 'AB23454565')->where('currency', 'USD')->first();    
        $account_id = $accountId1 ->account_id;
        $response = $this->get('/api/v1/transactions?account_id='.$account_id.'&offset=0&limit=5');        
        $data = json_decode($response->getContent(), true);
        
        $response->assertStatus(200);
        if (count($data['data']) < 1) {
            $this->assertSame(0, count($data['data']));    
            return true;
        }
        
        $this->assertArrayHasKey('amount', $data['data'][0]);
        $this->assertArrayHasKey('transaction_type', $data['data'][0]);
    }
}
