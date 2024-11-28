<?php

namespace App\P2p\BankTransferDetails;

use App\Models\BankTransferDetail as BankTransferDetailModel;

class BankTransferDetail implements BankTransferDetailInterface
{
    public function getAllBy(array $params)
    {
        $query = BankTransferDetailModel::query();
        if (!empty($params['id'])) {
            $query->where('id', $params['id']);
        }
        if (isset($params['is_active'])) {
            $query->where('is_active', $params['is_active']);
        }
        if (!empty($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
        }
        if (!empty($params['is_default'])) {
            $query->where('is_default', $params['is_default']);
        }
        return $query->get();
    }
}
