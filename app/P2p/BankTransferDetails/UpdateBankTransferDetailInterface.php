<?php

namespace App\P2p\BankTransferDetails;

interface UpdateBankTransferDetailInterface
{
    public function process(array $data): bool;
}
