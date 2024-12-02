<?php

namespace App\P2p\ChatP2pTransactions;

use App\Models\P2pTransaction;
use App\Models\P2pTransactionsChat;

class P2pChat implements P2pChatInterface
{
    public function getBy(array $params)
    {
        $query = P2pTransactionsChat::query();
        if (!empty($params['limit'])) {
            $query->limit($params['limit']);
        }
        if (!empty($params['offset'])) {
            $query->offset($params['offset']);
        }
        if (!empty($params['p2p_transaction_reference'])) {
            $p2pTransaction = P2pTransaction::where('reference', $params['p2p_transaction_reference'])
                ->with("p2pAd")->first();
            $partnerUserId = $p2pTransaction->partner_user_id;
            $userId = $p2pTransaction->p2pAd->user_id;
            $query->orWhere(function ($q) use ($partnerUserId, $userId) {
                $q->where('by_user_id', '=', $userId);
                $q->where('user_chat_id', '=', $partnerUserId);
            });
            $query->orWhere(function ($q) use ($partnerUserId, $userId) {
                $q->where('by_user_id', '=', $partnerUserId);
                $q->where('user_chat_id', '=', $userId);
            });
        }

        $query->with("userChat:id,name");
        $query->with("byUser:id,name");
        return $query->orderBy("id", "DESC")->get();
    }

    public function find(int $id)
    {
        return P2pTransactionsChat::find($id);
    }
}
