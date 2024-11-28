<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class P2pTransaction extends Model
{
    protected $table = 'p2p_transactions';

    const INITIATE = "INITIATE";
    const PARTNER_TRANSFER = "PARTNER_TRANSFER";
    const SUCCESS = "SUCCESS";
    const CANCEL = "CANCEL";
    const APPEAL_PENDING = "PENDING";
    const APPEAL_COMPLETE = "COMPLETE";

    protected $fillable = ['p2p_ad_id', 'partner_user_id', 'coin_amount', 'start_process', 'end_process', 'status',
        'expired_process', 'reference', 'appeal_status'];

    public function p2pAd(): HasOne
    {
        return $this->hasOne(P2pAd::class, 'id', 'p2p_ad_id');
    }
}
