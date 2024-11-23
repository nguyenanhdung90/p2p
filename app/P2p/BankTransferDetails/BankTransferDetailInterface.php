<?php

namespace App\P2p\BankTransferDetails;

interface BankTransferDetailInterface
{
    public function create(array $data);

    public function update(array $data): bool;

    public function getAllBy(array $params);
}
