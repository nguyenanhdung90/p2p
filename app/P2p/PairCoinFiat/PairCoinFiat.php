<?php

namespace App\P2p\PairCoinFiat;

use App\Models\CoinInfo;
use App\Models\FiatInfo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PairCoinFiat implements PairCoinFiatInterface
{
    public function updatePairCoinFiat(string $coin, array $fiat, int $maxFiatPrice): bool
    {
        try {
            $coinInfo = CoinInfo::where("currency", $coin)->where('is_active', true)->first();
            $fiat = FiatInfo::where("currency", $fiat)->get()->pluck('id')->toArray();
            if (empty($fiat)) {
                return false;
            }
            $coinInfo->fiats()->syncWithoutDetaching([$fiat->id => ['max_fiat_price' => $maxFiatPrice]]);
            return true;
        } catch (\Exception $e) {
            Log::error("mapFiats: " . $e->getMessage());
            return false;
        }
    }

    public function deletePairCoinFiat(string $coin, string $fiat): bool
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

    public function getPairCoinFiatBy(?string $coin, ?array $fiats): Collection
    {
        $query = CoinInfo::query()->where('is_active', true);
        if ($coin) {
            $query->where("currency", $coin);
        }
        if (empty($fiats)) {
            $query->has("fiats", ">", 0)->with("fiats");
        } else {
            $query->with(['fiats' => function ($q) use ($fiats) {
                $q->whereIN('currency', $fiats);
            }]);
        }
        $coinInfo = $query->get();
        $coinInfo->transform(function ($coin, $key) {
            $fiats = $coin->fiats;
            $fiats->transform(function ($fiat, $key) use ($coin) {
                return $coin->currency . "|" . $fiat->currency;
            });
            return $fiats;
        });
        return $coinInfo->collapse();
    }
}
