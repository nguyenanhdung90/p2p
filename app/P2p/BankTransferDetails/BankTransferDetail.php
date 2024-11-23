<?php

namespace App\P2p\BankTransferDetails;

use App\Models\BankTransferDetail as BankTransferDetailModel;

class BankTransferDetail implements BankTransferDetailInterface
{
    public function create(array $data)
    {
        return BankTransferDetailModel::create($data);
    }

    public function update(array $data): bool
    {
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
        $bankDetail->save();
        return true;
    }

    public function getAllBy(array $params)
    {
        $query = BankTransferDetailModel::query()->where('is_active', true);
        if (!empty($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
        }
        if (!empty($params['is_default'])) {
            $query->where('is_default', $params['is_default']);
        }
        return $query->get();
    }
}
