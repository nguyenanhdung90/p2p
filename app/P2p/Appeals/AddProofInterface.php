<?php

namespace App\P2p\Appeals;

interface AddProofInterface
{
    public function process(array $params): bool;
}
