<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateP2pAdRequest;
use App\P2p\Ads\P2pAdInterface;

class P2pAdController extends Controller
{
    public function create(CreateP2pAdRequest $request, P2pAdInterface $p2pAd)
    {
        return 123;
    }
}
