<?php

namespace App\P2p\Ads;

use App\Models\P2pAd as P2pAdModel;

class P2pAd implements P2pAdInterface
{
    public function createAd(array $data)
    {
        return P2pAdModel::create($data);
    }

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
}
