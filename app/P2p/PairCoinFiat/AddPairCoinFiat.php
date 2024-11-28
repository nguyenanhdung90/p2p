<?php

namespace App\P2p\PairCoinFiat;

use App\Models\CoinInfo;
use App\Models\FiatInfo;
use Illuminate\Support\Facades\Log;

class AddPairCoinFiat implements AddPairCoinFiatInterface
{
    public function process(string $coin, string $fiat, ?int $maxFiatPrice, ?int $minAmountCoin): bool
    {
        try {
            $coinInfo = CoinInfo::where("currency", $coin)->where('is_active', true)->first();
            $fiat = FiatInfo::where("currency", $fiat)->first();
            if (empty($fiat)) {
                return false;
            }
            $data = [];
            if (!empty($maxFiatPrice)) {
                $data["max_fiat_price"] = $maxFiatPrice;
            }
            if (!empty($minAmountCoin)) {
                $data["min_amount_coin"] = $minAmountCoin;
            }
            if (empty($data)) {
                return false;
            }
            $coinInfo->fiats()->syncWithoutDetaching([$fiat->id => $data]);
            return true;
        } catch (\Exception $e) {
            Log::error("mapFiats: " . $e->getMessage());
            return false;
        }
    }
}
