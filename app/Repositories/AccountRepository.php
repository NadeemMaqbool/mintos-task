<?php
namespace App\Repositories;

use App\Enum\TransactionTypeEnum;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\TestRunner\TestResult\Collector;

class AccountRepository {
    
    /**
     *
     * @param int $clientId
     * 
     * @return Account
     * 
     */
    public function getAccountsByClientId(string $clientId): Collection|null
    {
        return Account::where('client_id', $clientId)->get();
    }

    public function getAccountByAccountId(string $accountId): string|Account|null
    {
        return Account::where('account_id', $accountId)->first();
    }

    public function updateAccountCreditByAccountId(array $data): bool
    {
        $sender = $data['sender'];  
        $receiver = $data['receiver'];
        $senderNewBalance = $data['senderNewBalance'];
        $receiverNewBalance = $data['receiverNewBalance'];
        $amount = $data['amount'];
        
        // using DB::transaction incase anything went wrong it roll back all the quries
        DB::transaction(function () use(
            $sender, $receiver, $senderNewBalance, $receiverNewBalance, $amount
        ){
            /// Debit transaction for Sender
            DB::table('accounts')
            ->where('account_id', $sender)
            ->update([
                'amount' => $senderNewBalance
            ]);

            DB::table('accounts_transactions')
                ->insert([
                    'account_id' => $sender,
                    'amount' => $amount,
                    'transaction_id' => Str::random(10),
                    'transaction_type' => TransactionTypeEnum::DEBIT
                ]);

            // Credit transaction for Receiver
            DB::table('accounts')
            ->where('account_id', $receiver)
            ->update([
                'amount' => $receiverNewBalance
            ]);
            
            DB::table('accounts_transactions')
                ->insert([
                    'account_id' => $receiver,
                    'amount' => $amount,
                    'transaction_id' => Str::random(10),
                    'transaction_type' => TransactionTypeEnum::CREDIT
                ]);
        });

        return true;
    }

}