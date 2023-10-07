<?php
namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\AccountTransaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository {

    /**
     * [Description for getAllTransactyionsByAccountId]
     *
     * @param string $accountId
     * @param int $offset
     * @param int $limit
     * 
     * @return Collection
     * 
     */
    public function getAllTransactyionsByAccountId(
        string $accountId,
        int $offset,
        int $limit
    ) 
    {
        $query = AccountTransaction::where('account_id', $accountId)
            ->offset($offset)
            ->limit($limit)
            ->orderBy('account_id', 'DESC')
            ->toSql();
        dd($query);
    }

}