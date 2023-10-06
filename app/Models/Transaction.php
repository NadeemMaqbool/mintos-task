<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function accountTransaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }
}
