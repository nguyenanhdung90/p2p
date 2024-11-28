<?php

namespace App\P2p\Appeal;

use App\Models\P2pTransaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InitiateAppeal implements InitiateAppealInterface
{
    public function process(array $data)
    {
        DB::beginTransaction();
        try {
            $reasonTran = Arr::only($data, ['reason_id', 'p2p_transaction_id', 'by_user_id', 'created_at',
                'updated_at']);
            $reasonTranId = DB::table("reason_p2p_transactions")->insertGetId($reasonTran);
            $data["reason_p2p_transactions_id"] = $reasonTranId;
            $reasonTranDetail = Arr::only($data, ['reason_p2p_transactions_id', 'by_user_id', 'description',
                'created_at', 'updated_at', 'img']);
            DB::table("reason_p2p_transaction_details")->insert($reasonTranDetail);
            DB::table("p2p_transactions")
                ->where("id", $data['p2p_transaction_id'])
                ->update(["appeal_status" => P2pTransaction::APPEAL_PENDING]);
            DB::commit();
            return $reasonTranId;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error InitiateAppeal: " . $e->getMessage());
            return false;
        }
    }
}
