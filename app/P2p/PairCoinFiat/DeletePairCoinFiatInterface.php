<?php

namespace App\P2p\PairCoinFiat;

interface DeletePairCoinFiatInterface
{
    public function process(string $coin, string $fiat): bool;
}
