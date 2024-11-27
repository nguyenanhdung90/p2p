<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateP2pAdRequest;
use App\P2p\Ads\InitiateAdInterface;
use App\P2p\Ads\P2pAdInterface;

class P2pAdController extends Controller
{
    public function create(
        CreateP2pAdRequest $request,
        InitiateAdInterface $initiateAd,
        P2pAdInterface $p2pAd
    ) {
        try {
            $result = $initiateAd->process($request->all());
            return response(json_encode([
                "success" => is_numeric($result),
                "data" => $p2pAd->getAdById((int)$result)
            ]));
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }
}
