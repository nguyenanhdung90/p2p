<?php

namespace App\P2p\BankTransferDetails;

use App\Models\BankTransferDetail as BankTransferDetailModel;
use Illuminate\Support\Facades\Log;

class UpdateBankTransferDetail implements UpdateBankTransferDetailInterface
{
    public function process(array $data): bool
    {
        try {
            $bankDetail = BankTransferDetailModel::find($data['id']);
            if (!$bankDetail) {
                return false;
            }
            if ($bankDetail->user_id != $data['user_id']) {
                return false;
            }
            if (!empty($data['account_name'])) {
                $bankDetail->account_name = $data['account_name'];
            }
            if (!empty($data['bank_name'])) {
                $bankDetail->bank_name = $data['bank_name'];
            }
            if (!empty($data['bank_account'])) {
                $bankDetail->bank_account = $data['bank_account'];
            }
            if (isset($data['is_active'])) {
                $bankDetail->is_active = (bool)$data['is_active'];
            }
            if (isset($data['is_default'])) {
                $bankDetail->is_default = (bool)$data['is_default'];
            }
            if (!empty($data['status'])) {
                $bankDetail->status = $data['status'];
            }
            $bankDetail->save();
            return true;
        } catch (\Exception $e) {
            Log::error("Error update BankTransferDetail: " . $e->getMessage());
            return false;
        }
    }
}
