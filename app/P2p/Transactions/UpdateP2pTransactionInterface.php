<?php

namespace App\P2p\Transactions;

interface UpdateP2pTransactionInterface
{
    public function process(int $id, array $params): bool;
}
