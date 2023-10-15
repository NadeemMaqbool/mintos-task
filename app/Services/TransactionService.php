<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Cache;
use App\Repositories\AccountRepository;
use App\Services\CurrencyExchangeService;
use App\Repositories\TransactionRepository;

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
        
        if (!$senderAccountDetails || !$receiverAccounDetails) {
            throw new CustomException('Account id does not exist');
        }
        
        if ($receiverAccounDetails->currency !== $currency) {
            throw new CustomException('Requested currency does not match with receiver account');
        }

        $convertedAmount = $this->currencyExchangeService->getCurrencyExchange(
            $senderAccountDetails->currency,
            $currency,
            $amount
        );

        if (!$convertedAmount) {
            $convertedAmount = Cache::get($currency);
            
            if (!$convertedAmount) {
                throw new CustomException('Error while retrieving currency exchange');
            }
        } else {
            Cache::put($currency, $convertedAmount, 30*60);
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