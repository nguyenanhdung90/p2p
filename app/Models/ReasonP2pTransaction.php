<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
