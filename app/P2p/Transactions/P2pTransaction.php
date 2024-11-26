<?php

namespace App\P2p\Transactions;

use App\Models\P2pAd;
use App\Models\P2pTransaction as P2pTransactionModel;
use App\User;
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
            if (!$wallet) {
                DB::rollBack();
                return false;
            }
            if ($ad->type === P2pAd::BUY) {
                $updatedP2pAmount = $wallet->p2p_amount - $ad->coin_amount;
                if ($updatedP2pAmount < 0) {
                    DB::rollBack();
                    return false;
                }
                $updatedLockedAmount = $wallet->locked_amount + $ad->coin_amount;
                DB::table('wallets')
                    ->where("id", $wallet->id)
                    ->update([
                        "p2p_amount" => $updatedP2pAmount,
                        "locked_amount" => $updatedLockedAmount,
                    ]);
            }

            Arr::only($data, 'p2p_ad_id', 'partner_user_id', 'coin_amount', 'start_process', 'end_process', 'status',
                'expired_process', 'reference', 'created_at', 'updated_at');
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

    public function successTransfer(array $data): bool
    {
        DB::beginTransaction();
        try {
            $tran = DB::table('p2p_transactions')
                ->where("id", $data['id'])
                ->where("partner_user_id", "!=", $data['user_id'])
                ->where("status", P2pTransactionModel::PARTNER_TRANSFER)
                ->lockForUpdate()
                ->first();
            if (!$tran) {
                DB::rollBack();
                return false;
            }
            $ad = DB::table('p2p_ads')->where("id", $tran->p2p_ad_id)
                ->where('is_active', false)
                ->where('user_id', $data['user_id'])
                ->first();
            if (!$ad) {
                DB::rollBack();
                return false;
            }

            $walletMerchant = DB::table('wallets')
                ->where('user_name', $data['user_name'])
                ->where('currency', $ad->coin_currency)
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();
            $userPartner = User::find($tran->partner_user_id);
            $walletPartner = DB::table('wallets')
                ->where('user_name', $userPartner->name)
                ->where('currency', $ad->coin_currency)
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();
            if (!$walletMerchant || !$walletPartner) {
                DB::rollBack();
                return false;
            }

            if ($ad->type === P2pAd::SELL) {
                $updatedLockedAmountMerchant = $walletMerchant->locked_amount - $ad->coin_amount;
                $updatedP2pAmountMerchant = $walletMerchant->p2p_amount + $ad->coin_amount - $tran->coin_amount;
                DB::table('wallets')->where("id", $walletMerchant->id)
                    ->update([
                        "locked_amount" => $updatedLockedAmountMerchant,
                        "p2p_amount" => $updatedP2pAmountMerchant,
                    ]);
                $updatedP2pAmountPartner = $walletPartner->p2p_amount + $tran->coin_amount;
                DB::table('wallets')->where("id", $walletPartner->id)
                    ->update([
                        "p2p_amount" => $updatedP2pAmountPartner,
                    ]);
            } else {
                $updatedP2pAmountMerchant = $walletMerchant->p2p_amount + $tran->coin_amount;
                DB::table('wallets')->where("id", $walletMerchant->id)
                    ->update([
                        "p2p_amount" => $updatedP2pAmountMerchant,
                    ]);

                $updatedLockedAmountPartner = $walletPartner->locked_amount - $ad->coin_amount;
                $updatedP2pAmountPartner = $walletPartner->p2p_amount + $ad->coin_amount - $tran->coin_amount;
                DB::table('wallets')->where("id", $walletPartner->id)
                    ->update([
                        "locked_amount" => $updatedLockedAmountPartner,
                        "p2p_amount" => $updatedP2pAmountPartner,
                    ]);
            }

            DB::table('p2p_transactions')
                ->where("id", $data['id'])
                ->update([
                    "status" => P2pTransactionModel::SUCCESS
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
