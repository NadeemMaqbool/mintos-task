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
use Exception;

class TransactionsController extends Controller
{
    public function __construct(
        public TransactionRepository $transactionRepository,
        public TransactionService $transactionService
    )
    {}


    /**
     * [get transaction history (last transactions come first) using 'offset' and 'limit']
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTransactionHistory(Request $request): JsonResponse 
    {
        try {
            $validator = Validator::make($request->all(), [
                "account_id" => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error: '. $validator->errors()
                ], 400);
            }
    
            $accountId = $request->account_id;
            $offset = $request->offset ?? 0;
            $limit = $request->limit ?? 5;
    
            $transactions = $this->transactionRepository->getAllTransactyionsByAccountId(
                $accountId, $offset, $limit
            );
            
            return response()->json([
                'message' => 'Transaction history for account ' . $accountId,
                'data' => $transactions
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error: '. $e->getMessage()
            ], 400);
        }
        
    }

    /**
     * [Transfer funds between two accounts identified by ids]
     *
     * @param Request $request
     * @return JsonResponse
     * 
     */
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
