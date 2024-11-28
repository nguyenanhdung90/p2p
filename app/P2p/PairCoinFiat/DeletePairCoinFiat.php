<?php

namespace App\P2p\PairCoinFiat;

use App\Models\CoinInfo;
use App\Models\FiatInfo;
use Illuminate\Support\Facades\Log;

class DeletePairCoinFiat implements DeletePairCoinFiatInterface
{
    public function process(string $coin, string $fiat): bool
    {
        try {
            $coinInfo = CoinInfo::where("currency", $coin)->where('is_active', true)->first();
            $fiat = FiatInfo::where("currency", $fiat)->first();
            $coinInfo->fiats()->detach($fiat->id);
            return true;
        } catch (\Exception $e) {
            Log::error("createPairCoinFiat: " . $e->getMessage());
            return false;
        }
    }
}
