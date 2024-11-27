<?php

namespace App\P2p\Transactions;

interface InitiateTransactionInterface
{
    public function process(array $data);
}
