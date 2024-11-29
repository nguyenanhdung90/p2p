<?php

namespace App\P2p\Appeals;

use App\Models\ReasonP2pTransaction;

class Appeal implements AppealInterface
{
    public function getById(int $id)
    {
        $data = ReasonP2pTransaction::where("id", $id)->with("reasonP2pTransactionDetails")->first();
        if (!$data) {
            return [];
        }
        return $data->toArray();
    }
}
