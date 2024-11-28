<?php

namespace App\P2p\PairCoinFiat;

use App\Models\CoinInfo;
use Illuminate\Support\Collection;

class PairCoinFiat implements PairCoinFiatInterface
{
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
