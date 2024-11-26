<?php

namespace App\P2p\PairCoinFiat;

use App\Models\CoinInfo;
use App\Models\FiatInfo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PairCoinFiat implements PairCoinFiatInterface
{
    public function updatePairCoinFiat(string $coin, string $fiat, ?int $maxFiatPrice, ?int $minAmountCoin): bool
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

    public function getCoinFiatPivotBy(?string $coin, ?string $fiat): Collection
    {
        $query = CoinInfo::query()->where('is_active', true);
        if ($coin) {
            $query->where("currency", $coin);
        }
        if (empty($fiat)) {
            $query->has("fiats", ">", 0)->with("fiats");
        } else {
            $query->with(['fiats' => function ($q) use ($fiat) {
                $q->where('currency', $fiat);
            }]);
        }
        $coinInfo = $query->get();
        $coinInfo->transform(function ($coin, $key) {
            $fiats = $coin->fiats;
            $fiats->transform(function ($fiat, $key) use ($coin) {
                return [
                    "coin" => $coin->currency,
                    "fiat" => $fiat->currency,
                    "max_fiat_price" => $fiat->pivot->max_fiat_price,
                    "min_amount_coin" => $fiat->pivot->min_amount_coin
                ];
            });
            return $fiats;
        });
        return $coinInfo->collapse();
    }
}
