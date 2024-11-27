<?php

namespace App\P2p\Transactions;

interface ConfirmTransferInterface
{
    public function process(array $data): bool;
}
