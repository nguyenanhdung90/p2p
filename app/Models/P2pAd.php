<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2pAd extends Model
{
    const BANK_TRANSFER = "BANK_TRANSFER";

    protected $table = 'p2p_ads';

    protected $fillable = [
        'fiat_price', 'fiat_currency', 'coin_amount', 'coin_currency', 'coin_minimum_amount', 'coin_maximum_amount',
        'type', 'user_id', 'payment_method', 'bank_transfer_detail_id', 'is_active'
    ];
}
