<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReasonP2pTransaction extends Model
{
    const PENDING = "PENDING";
    const FAILED = "FAILED";
    const SUCCESS = "SUCCESS";
    const RESOLVED = "RESOLVED";

    protected $table = 'reason_p2p_transactions';

    protected $fillable = [
        'reason_id', 'p2p_transaction_id', 'by_user_id', 'status'
    ];

    public function reasonP2pTransactionDetails(): HasMany
    {
        return $this->hasMany(ReasonP2pTransactionDetail::class, 'reason_p2p_transactions_id', 'id');
    }

    public function p2pTransaction(): HasOne
    {
        return $this->hasOne(P2pTransaction::class, 'id', 'p2p_transaction_id');
    }
}
