<?php

namespace App\P2p\Ads;

use App\Models\P2pAd as P2pAdModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InitiateAd implements InitiateAdInterface
{
    public function proccess(array $data)
    {
        DB::beginTransaction();
        try {
            $wallet = DB::table('wallets')
                ->where("user_name", auth()->user()->name)
                ->where("currency", $data['coin_currency'])
                ->where("is_active", true)
                ->lockForUpdate()
                ->first();
            if (!$wallet) {
                DB::rollBack();
                return false;
            }
            if ($data['type'] === P2pAdModel::SELL) {
                $remainP2pAmount = $wallet->p2p_amount - $data['coin_amount'];
                if ($remainP2pAmount < 0) {
                    DB::rollBack();
                    return false;
                }
                $lockedAmount = $wallet->p2p_amount + $data['coin_amount'];
                DB::table('wallets')
                    ->where("id", $wallet->id)
                    ->update([
                        "p2p_amount" => $remainP2pAmount,
                        "locked_amount" => $lockedAmount,
                    ]);
            }
            $adData = Arr::only($data, ['fiat_price', 'fiat_currency', 'coin_amount', 'coin_currency', 'coin_minimum_amount', 'coin_maximum_amount',
                'type', 'user_id', 'payment_method', 'bank_transfer_detail_id', 'is_active', 'created_at', 'updated_at']);
            $id = DB::table('p2p_ads')->insertGetId($adData);
            DB::commit();
            return $id;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error initiateAd: " . $e->getMessage());
            return false;
        }
    }
}
