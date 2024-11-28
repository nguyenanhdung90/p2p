<?php

namespace App\P2p\Transactions;

interface P2pTransactionInterface
{
    public function getTranById(int $id): array;
}
