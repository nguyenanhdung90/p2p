<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2pTransaction extends Model
{
    protected $table = 'p2p_transactions';

    const INITIATE = "INITIATE";
    const PARTNER_TRANSFER = "PARTNER_TRANSFER";
    const SELF_RECEIVED = "SELF_RECEIVED";
    const CLAIM_FAILED_PAYMENT = "CLAIM_FAILED_PAYMENT";
    const SUCCESS = "SUCCESS";
    const CANCEL = "CANCEL";

    protected $fillable = ['p2p_ad_id', 'partner_user_id', 'coin_amount', 'start_process', 'end_process', 'status',
        'expired_process', 'reference'];
}
