<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CoinInfo extends Model
{
    protected $table = 'coin_infos';

    protected $fillable = [
        'name', 'description', 'image', 'currency', 'decimals', 'is_active'
    ];

    public function fiats(): BelongsToMany
    {
        return $this->belongsToMany(FiatInfo::class, 'p2p_coin_fiat_pairs', 'coin_info_id', 'fiat_info_id')
            ->withPivot('max_fiat_price')
            ->withTimestamps();
    }
}
