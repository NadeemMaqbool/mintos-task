<?php

namespace App\Services;

use App\Exceptions\CustomException;
use Illuminate\Http\Request;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use App\Services\CurrencyExchangeService;

class TransactionService {
    public function __construct(
        protected AccountRepository $accountRepository,
        protected TransactionRepository $transactionRepository,
        protected CurrencyExchangeService $currencyExchangeService
    ) 
    {}

    public function transferAmountInAccount(Request $request)
    {
        $data = $request->all();
        $sender = $data['senderAccountId'];
        $receiver = $data['receiverAccountId'];
        $amount = $data['amount'];
        $currency = $data['currency'];

        $senderAccountDetails = $this->accountRepository->getAccountByAccountId($sender);
        $receiverAccounDetails = $this->accountRepository->getAccountByAccountId($receiver);
        
        $convertedAmount = $this->currencyExchangeService->getCurrencyExchange(
            $senderAccountDetails->currency,
            $currency,
            $amount
        );

        if ($receiverAccounDetails->currency !== $currency) {
            throw new CustomException('Requested currency does not match with receiver account');
        }

        $senderNewBalance = $senderAccountDetails->amount - $convertedAmount;
        
        if ($senderNewBalance < 0) {
            throw new CustomException('Transaction failed as sender account does not have enough balance');
        }

        $receiverNewBalance = $receiverAccounDetails->amount + $amount; 
        
        $data = [
            'sender' => $sender,
            'receiver' => $receiver,
            'amount' => $amount.' '.$currency,
            'senderNewBalance' => $senderNewBalance,
            'receiverNewBalance' => $receiverNewBalance
        ];

        $this->accountRepository->updateAccountCreditByAccountId($data);

        return $amount;
    }
}