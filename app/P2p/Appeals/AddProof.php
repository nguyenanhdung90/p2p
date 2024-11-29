<?php

namespace App\P2p\Appeals;

use Illuminate\Support\Facades\DB;

class AddProof implements AddProofInterface
{
    public function process(array $params): bool
    {
        return DB::table("reason_p2p_transaction_details")->insert($params);
    }
}
