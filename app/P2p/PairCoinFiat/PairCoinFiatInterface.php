<?php

namespace App\P2p\PairCoinFiat;

interface PairCoinFiatInterface
{
    public function mapPairCoinFiats(string $coin, array $fiats): bool;

    public function createPairCoinFiat(string $coin, string $fiat): bool;

    public function deletePairCoinFiat(string $coin, string $fiat): bool;

    public function getPairCoinFiatBy(?string $coin, ?array $fiats);
}
