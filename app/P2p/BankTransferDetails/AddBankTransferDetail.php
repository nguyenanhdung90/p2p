<?php

namespace App\P2p\BankTransferDetails;

use Illuminate\Support\Facades\DB;

class AddBankTransferDetail implements AddBankTransferDetailInterface
{
    public function process(array $data): int
    {
        return DB::table("bank_transfer_details")->insertGetId($data);
    }
}
