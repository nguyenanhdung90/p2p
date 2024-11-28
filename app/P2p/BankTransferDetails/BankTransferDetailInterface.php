<?php

namespace App\P2p\BankTransferDetails;

interface BankTransferDetailInterface
{
    public function getAllBy(array $params);
}
