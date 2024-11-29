<?php

namespace App\P2p\ChatP2pTransactions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AddMessage implements AddMessageInterface
{
    public function process(array $data): int
    {
        return DB::table("p2p_transactions_chats")->insertGetId(Arr::only($data,
            ['p2p_transaction_id', 'by_user_id', 'user_chat_id', 'data'
                , 'created_at', 'updated_at']));
    }
}
