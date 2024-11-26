<?php

namespace App\P2p\Ads;

interface P2pAdInterface
{
    public function initiateAd(array $data);

    public function updateBy(int $id, array $params);
}
