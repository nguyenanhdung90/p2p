<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2pTransaction extends Model
{
    protected $table = 'p2p_transactions';

    const INITIATE = "INITIATE";
    const CONFIRM_PAYMENT = "CONFIRM_PAYMENT";
    const FAILED_PAYMENT = "FAILED_PAYMENT";
    const SUCCESS = "SUCCESS";
    const CANCEL = "CANCEL";

    protected $fillable = ['p2p_ad_id', 'partner_user_id', 'coin_amount', 'start_process', 'end_process', 'status',
        'limit_process'];
}
