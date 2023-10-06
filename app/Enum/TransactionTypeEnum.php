<?php

namespace App\Enum;

enum TransactionTypeEnum: string 
{
    case DEBIT = 'debit';
    case CREDIT = 'credit';
}