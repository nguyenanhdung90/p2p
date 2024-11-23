<?php

namespace App\P2p\PairCoinFiat;

interface PairCoinFiatInterface
{
    public function updatePairCoinFiat(string $coin, string $fiat, int $maxFiatPrice): bool;

    public function deletePairCoinFiat(string $coin, string $fiat): bool;

    public function getPairCoinFiatBy(?string $coin, ?array $fiats);
}
