<?php

namespace App\P2p\Transactions;

use App\Models\P2pAd;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InitiateTransaction implements InitiateTransactionInterface
{
    public function process(array $data)
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
            $walletPartner = DB::table('wallets')
                ->where("user_name", auth()->user()->name)
                ->where("currency", $ad->coin_currency)
                ->where("is_active", true)
                ->lockForUpdate()
                ->first();
            if (!$walletPartner) {
                DB::rollBack();
                return false;
            }
            if ($ad->type === P2pAd::BUY) {
                $updatedP2pAmount = $walletPartner->p2p_amount - $ad->coin_amount;
                if ($updatedP2pAmount < 0) {
                    DB::rollBack();
                    return false;
                }
                $updatedLockedAmount = $walletPartner->locked_amount + $ad->coin_amount;
                DB::table('wallets')
                    ->where("id", $walletPartner->id)
                    ->update([
                        "p2p_amount" => $updatedP2pAmount,
                        "locked_amount" => $updatedLockedAmount,
                    ]);
            }

            Arr::only($data, 'p2p_ad_id', 'partner_user_id', 'coin_amount', 'start_process', 'end_process', 'status',
                'expired_process', 'reference', 'created_at', 'updated_at');
            $id = DB::table('p2p_transactions')->insertGetId($data);
            DB::table('p2p_ads')
                ->where("id", $data["p2p_ad_id"])
                ->update([
                    "is_active" => false
                ]);
            DB::commit();
            return $id;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error: " . $e->getMessage());
            return false;
        }
    }
}
