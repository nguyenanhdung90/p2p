<?php

namespace App\P2p\Transactions;

use App\Models\P2pTransaction as P2pTransactionModel;

class P2pTransaction implements P2pTransactionInterface
{
    public function create(array $data)
    {
        return P2pTransactionModel::create($data);
    }
}
