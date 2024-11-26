<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'user_name', 'amount', 'locked_amount', 'p2p_amount', 'currency', 'is_active'
    ];

    public function coinInfo(): HasOne
    {
        return $this->hasOne(CoinInfo::class, 'currency', 'currency');
    }
}
