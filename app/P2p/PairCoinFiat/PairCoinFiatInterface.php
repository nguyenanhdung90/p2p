<?php

namespace App\P2p\PairCoinFiat;

use Illuminate\Support\Collection;

interface PairCoinFiatInterface
{
    public function updatePairCoinFiat(string $coin, string $fiat, ?int $maxFiatPrice, ?int $minAmountCoin): bool;

    public function deletePairCoinFiat(string $coin, string $fiat): bool;

    public function getPairCoinFiatBy(?string $coin, ?array $fiats);

    public function getCoinFiatPivotBy(?string $coin, ?string $fiat): Collection;
}
