<?php

namespace App\Models;

use App\Enum\AccountTypesEnum;
use App\Enum\CurrencyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'currency', 'amount', 'client_id', 'account_type'];

    
    public function accountsTransactions() {
        return $this->hasMany(AccountTransaction::class, 'account_id', 'account_id');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }
}
