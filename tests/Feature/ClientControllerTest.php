<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientControllerTest extends TestCase
{   
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

       $this->seed(DatabaseSeeder::class);
    }

    /**
     * A basic feature test example.
     */
    public function test_get_all_accounts_against_client_id(): void
    {
        $clientId = 'SE77881100';
        $response = $this->get('/api/v1/client/'.$clientId);
        
        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $data = json_decode($response->getContent(), true);
        
        $this->assertArrayHasKey('currency', $data['data'][0]);
    }
}
