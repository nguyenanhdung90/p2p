<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonP2pTransactionDetail extends Model
{
    protected $table = 'reason_p2p_transaction_details';

    protected $fillable = [
        'reason_p2p_transactions_id', 'by_user_id', 'description', 'img'
    ];
}
