<?php

namespace App\P2p\Transactions;

use Illuminate\Database\Eloquent\Model;

interface P2pTransactionInterface
{
    public function initiateTransaction(array $data): bool;

    public function update($id, $params): ?Model;
}
