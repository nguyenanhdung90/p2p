<?php

namespace App\P2p\Transactions;

use Illuminate\Database\Eloquent\Model;

interface P2pTransactionInterface
{
    public function update($id, $params): ?Model;

    public function findBy(int $id): ?Model;
}
