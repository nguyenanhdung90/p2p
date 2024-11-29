<?php

namespace App\P2p\Appeals;

use App\Models\P2pTransaction;
use App\Models\ReasonP2pTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateStatus implements UpdateStatusInterface
{
    public function process(int $reasonTransactionId, string $status): bool
    {
        DB::beginTransaction();
        try {
            $reason = DB::table('reason_p2p_transactions')
                ->where('id', $reasonTransactionId)
                ->lockForUpdate()
                ->first();
            if (!$reason || $reason->status !== ReasonP2pTransaction::PENDING) {
                DB::rollBack();
                return false;
            }
            DB::table('reason_p2p_transactions')
                ->where('id', $reasonTransactionId)
                ->update(['status' => $status]);
            DB::table("p2p_transactions")
                ->where("id", $reason->p2p_transaction_id)
                ->update(["appeal_status" => P2pTransaction::APPEAL_PENDING]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error InitiateAppeal: " . $e->getMessage());
            return false;
        }
    }
}
