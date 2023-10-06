<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionsController extends Controller
{
    public function __construct(
        public TransactionRepository $transactionRepository,
        public TransactionService $transactionService
    )
    {}


    public function getTransactionHistory(
        string $accountId,
        int $offset,
        int $limit
    ): JsonResponse 
    {
        $transactions = $this->transactionRepository->getAllTransactyionsByAccountId(
            $accountId, $offset, $limit
        );
        
        return response()->json([
            'message' => 'Transaction history for account ' . $accountId,
            'date' => $transactions
        ], 200);
    }

    public function transferMoney(Request $request): JsonResponse
    {
        $transaction = $this->transactionService->transferAmountInAccount($request);
        
        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction failed as sender account does not have enough balance'
            ], 200);    
        }

        return response()->json([
            'message' => 'Transaction completed successfully'
        ], 201);
    }
}
