<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class P2pTransactionsChat extends Model
{
    protected $table = 'p2p_transactions_chats';

    protected $fillable = ['p2p_transaction_id', 'by_user_id', 'user_chat_id', 'data'];

    public function p2pTransaction(): HasOne
    {
        return $this->hasOne(P2pTransaction::class, 'id', 'p2p_transaction_id');
    }

    public function byUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'by_user_id');
    }

    public function userChat(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_chat_id');
    }
}
