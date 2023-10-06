<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;

class TransactionService {
    public function __construct(
        public AccountRepository $accountRepository,
        public TransactionRepository $transactionRepository
    ) 
    {}

    public function transferAmountInAccount(Request $request)
    {
        $data = $request->all();
        $sender = $data['senderAccountId'];
        $receiver = $data['receiverAccountId'];
        $amount = $data['amount'];

        $senderAccountDetails = $this->accountRepository->getAccountByAccountId($sender);
        $receiverAccounDetails = $this->accountRepository->getAccountByAccountId($receiver);

        $senderNewBalance = $senderAccountDetails->amount - $amount;    
        
        if ($senderNewBalance < 0 && $amount > 0) {
            return false;
        }

        $receiverNewBalance = $receiverAccounDetails->amount + $amount;
        
        $data = [
            'sender' => $sender,
            'receiver' => $receiver,
            'amount' => $amount,
            'senderNewBalance' => $senderNewBalance,
            'receiverNewBalance' => $receiverNewBalance
        ];

        $this->accountRepository->updateAccountCreditByAccountId($data);

        return $amount;
    }
}