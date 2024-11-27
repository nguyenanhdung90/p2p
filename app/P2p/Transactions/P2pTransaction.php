<?php

namespace App\P2p\Transactions;

use App\Models\P2pTransaction as P2pTransactionModel;
use Illuminate\Database\Eloquent\Model;

class P2pTransaction implements P2pTransactionInterface
{

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

    public function getTranById(int $id): array
    {
        $tran = P2pTransactionModel::find($id);
        if (!$tran) {
            return [];
        }
        return $tran->makeHidden(["partner_user_id", "id", "p2p_ad_id"])->toArray();
    }
}
