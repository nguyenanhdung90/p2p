<?php

namespace App\P2p\Appeal;

use Illuminate\Support\Facades\DB;

class UpdateStatus implements UpdateStatusInterface
{
    public function process(int $reasonTransactionId, string $status): int
    {
        return DB::table('reason_p2p_transactions')->where('id', $reasonTransactionId)
            ->update(['status' => $status]);
    }
}
