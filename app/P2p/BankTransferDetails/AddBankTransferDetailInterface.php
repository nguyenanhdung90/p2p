<?php

namespace App\P2p\BankTransferDetails;

interface AddBankTransferDetailInterface
{
    public function process(array $data): int;
}
