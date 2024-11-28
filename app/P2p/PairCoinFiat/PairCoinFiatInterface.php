<?php

namespace App\P2p\PairCoinFiat;

use Illuminate\Support\Collection;

interface PairCoinFiatInterface
{
    public function getPairCoinFiatBy(?string $coin, ?array $fiats);

    public function getCoinFiatPivotBy(?string $coin, ?string $fiat): Collection;
}
