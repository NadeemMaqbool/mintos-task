<?php

namespace App\Http\Controllers;

use App\Enum\CurrencyEnum;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Exceptions\CustomException;
use App\Services\TransactionService;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Validator;
use App\Repositories\TransactionRepository;
use App\Http\Requests\TransactionDataRequest;

class TransactionsController extends Controller
{
    public function __construct(
        public TransactionRepository $transactionRepository,
        public TransactionService $transactionService
    )
    {}


    public function getTransactionHistory(Request $request): JsonResponse 
    {
        $accountId = $request->account_id;
        $offset = $request->offset;
        $limit = $request->limit;

        logger('inputs', $request->all());

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
        try {
            $validator = Validator::make($request->all(), [
                "senderAccountId" => 'required',
                "receiverAccountId" => 'required',
                "amount" => 'required|gte:1',
                "currency" => ['required', new Enum(CurrencyEnum::class)]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error: '. $validator->errors()
                ], 400);
            }
            
            $this->transactionService->transferAmountInAccount($request);
            
            return response()->json([
                'message' => 'Transaction completed successfully'
            ], 201);

        } catch (CustomException $e) {
            return response()->json([
                'message' => 'Error: '. $e->getMessage()
            ], 400);
        }
    }
}
