<?php

namespace App\P2p\PairCoinFiat;

interface PairCoinFiatInterface
{
    public function mapFiats(string $coin, array $fiats);
}
