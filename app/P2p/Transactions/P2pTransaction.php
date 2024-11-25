<?php

namespace App\P2p\Transactions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P2pTransaction implements P2pTransactionInterface
{
    public function initiateTransaction(array $data): bool
    {
        DB::beginTransaction();
        try {
            $ad = DB::table('p2p_ads')
                ->where('id', $data["p2p_ad_id"])
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();
            if (!$ad) {
                DB::rollBack();
                return false;
            }
            DB::table('p2p_transactions')->insert($data);
            DB::table('p2p_ads')
                ->where("id", $data["p2p_ad_id"])
                ->update([
                    "is_active" => false
                ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error: " . $e->getMessage());
            return false;
        }
    }
}
