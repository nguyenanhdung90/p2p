<?php

namespace App\P2p\Appeal;

interface AddProofInterface
{
    public function process(array $params): bool;
}
