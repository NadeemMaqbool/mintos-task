<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;

    protected $table = 'accounts_transactions';

    protected $fillable = [
        'sender_account_id',
        'receiver_account_id',
        'amount',
        'transaction_id'
    ];

    public function senderAccounts() {
        return $this->belongsTo('sender_account_id', 'account_id');
    }

    public function receiverAccounts() {
        return $this->belongsTo('receiver_account_id', 'account_id');
    }

}
