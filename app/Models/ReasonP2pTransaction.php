<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function reason_p2p_transaction_details(): HasMany
    {
        return $this->hasMany(ReasonP2pTransactionDetail::class, 'reason_p2p_transactions_id', 'id');
    }
}
