<?php

namespace App\P2p\Ads;

interface P2pAdInterface
{
    public function updateBy(int $id, array $params);

    public function getAdById(int $result): array;
}
