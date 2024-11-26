<?php

namespace App\P2p\Transactions;

use App\Models\P2pTransaction as P2pTransactionModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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
            $wallet = DB::table('wallets')
                ->where("user_name", $data['user_name'])
                ->where("currency", $ad->coin_currency)
                ->where("is_active", true)
                ->lockForUpdate()
                ->first();
            if (!$wallet || $wallet->amount < $ad->coin_amount) {
                DB::rollBack();
                return false;
            }
            DB::table('wallets')
                ->where("id", $wallet->id)
                ->update([
                    "amount" => $wallet->amount - $ad->coin_amount,
                    "locked_amount" => $ad->coin_amount,
                ]);
            Arr::forget($data, 'user_name');
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

    public function update($id, $params): ?Model
    {
        $transaction = P2pTransactionModel::find($id);
        if (!$transaction) {
            return null;
        }
        if (!empty($params['status'])) {
            $transaction->status = $params['status'];
        }
        $transaction->save();
        return $transaction;
    }
}
