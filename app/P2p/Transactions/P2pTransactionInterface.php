<?php

namespace App\P2p\Transactions;

interface P2pTransactionInterface
{
    public function create(array $data);
}
