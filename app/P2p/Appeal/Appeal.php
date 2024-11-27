<?php

namespace App\P2p\Appeal;

use App\Models\ReasonP2pTransaction;

class Appeal implements AppealInterface
{
    public function getById(int $id)
    {
        $data = ReasonP2pTransaction::where("id", $id)->with("reason_p2p_transaction_details")->first();
        if (!$data) {
            return [];
        }
        return $data->toArray();
    }
}
