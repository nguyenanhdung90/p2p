<?php

namespace App\P2p\PairCoinFiat;

use App\Models\CoinInfo;
use App\Models\FiatInfo;

class PairCoinFiat implements PairCoinFiatInterface
{
    public function mapFiats(string $coin, array $fiats)
    {
        $coinInfo = CoinInfo::where("currency", $coin)->first();
        if (!$coinInfo) {
            return;
        }
        $fiats = FiatInfo::whereIn("currency", $fiats)->get()->pluck('id')->toArray();
        if (empty($fiats)) {
            return;
        }
        $coinInfo->fiats()->sync($fiats);
    }
}
