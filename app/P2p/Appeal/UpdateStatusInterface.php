<?php

namespace App\P2p\Appeal;

interface UpdateStatusInterface
{
    public function process(int $reasonTransactionId, string $status): bool;
}
