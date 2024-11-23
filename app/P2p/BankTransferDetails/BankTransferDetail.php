<?php

namespace App\P2p\BankTransferDetails;

use App\Models\BankTransferDetail as BankTransferDetailModel;

class BankTransferDetail implements BankTransferDetailInterface
{
    public function create(array $data)
    {
        return BankTransferDetailModel::create($data);
    }
}
