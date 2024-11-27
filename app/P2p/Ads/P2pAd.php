<?php

namespace App\P2p\Ads;

use App\Models\P2pAd as P2pAdModel;

class P2pAd implements P2pAdInterface
{
    public function updateBy(int $id, array $params)
    {
        $ad = P2pAdModel::find($id);
        if (!$ad) {
            return null;
        }
        if (isset($params['is_active'])) {
            $ad->is_active = $params['is_active'];
        }
        $ad->save();
        return $ad;
    }

    public function getAdById(int $result): array
    {
        $ad = P2pAdModel::find($result);
        if (!$ad) {
            return [];
        }
        return $ad->toArray();
    }
}
