<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonP2pTransaction extends Model
{
    protected $table = 'reason_p2p_transactions';

    protected $fillable = [
        'reason_id', 'p2p_transaction_id', 'by_user_id', 'status'
    ];
}
