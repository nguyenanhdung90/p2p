<?php

namespace App\P2p\Transactions;

use App\Models\P2pAd;
use App\Models\P2pTransaction as P2pTransactionModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfirmTransfer implements ConfirmTransferInterface
{
    public function process(array $data): bool
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $tran = DB::table('p2p_transactions')
                ->where("id", $data['id'])
                ->where("status", P2pTransactionModel::PARTNER_TRANSFER)
                ->lockForUpdate()
                ->first();
            if (!$tran) {
                DB::rollBack();
                return false;
            }
            $ad = DB::table('p2p_ads')->where("id", $tran->p2p_ad_id)
                ->where('is_active', false)
                ->first();
            if (!$ad) {
                DB::rollBack();
                return false;
            }

            $walletMerchant = DB::table('wallets')
                ->where('user_name', $user->name)
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
                    "status" => P2pTransactionModel::SUCCESS,
                    "end_process" => Carbon::now()
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
