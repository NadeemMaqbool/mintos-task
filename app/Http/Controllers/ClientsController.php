<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\AccountRepository;

class ClientsController extends Controller
{
    public function __construct(
        public AccountRepository $accountRepository
    ){}
    
    
    public function getAllAccounts(string $clientId): JsonResponse
    {
        $accounts = $this->accountRepository->getAccountsByClientId($clientId);
        
        return response()->json([
            'message' => 'clients with all the accounts',
            'data' => $accounts    
        ], 200);
    }
}
