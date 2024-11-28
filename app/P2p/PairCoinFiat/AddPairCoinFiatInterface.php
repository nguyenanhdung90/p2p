<?php

namespace App\P2p\PairCoinFiat;

interface AddPairCoinFiatInterface
{
    public function process(string $coin, string $fiat, ?int $maxFiatPrice, ?int $minAmountCoin): bool;
}
