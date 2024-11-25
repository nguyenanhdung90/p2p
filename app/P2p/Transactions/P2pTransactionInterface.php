<?php

namespace App\P2p\Transactions;

interface P2pTransactionInterface
{
    public function initiateTransaction(array $data): bool;
}
