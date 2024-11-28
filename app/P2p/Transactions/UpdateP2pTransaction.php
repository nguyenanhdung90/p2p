<?php

namespace App\P2p\Transactions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateP2pTransaction implements UpdateP2pTransactionInterface
{
    public function process(int $id, array $params): bool
    {
        try {
            $record = DB::table("p2p_transactions")
                ->where("id", $id)
                ->update($params);
            return $record > 0;
        } catch (\Exception $e) {
            Log::error("Error UpdateP2pTransaction: " . $e->getMessage());
            return false;
        }
    }
}
