<?php

namespace App\P2p\Appeals;

interface UpdateStatusInterface
{
    public function process(int $reasonTransactionId, string $status): bool;
}
