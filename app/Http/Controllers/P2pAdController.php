<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateP2pAdRequest;
use App\P2p\Ads\P2pAdInterface;

class P2pAdController extends Controller
{
    public function create(CreateP2pAdRequest $request, P2pAdInterface $p2pAd)
    {
        try {
            $data = $request->all();
            return response(json_encode(["success" => $p2pAd->initiateAd($data)]), 200);
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }
}
