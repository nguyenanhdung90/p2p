<?php

namespace App\P2p\ChatP2pTransactions;

interface AddMessageInterface
{
    public function process(array $data): int;
}
