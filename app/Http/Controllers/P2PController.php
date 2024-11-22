<?php

namespace App\Http\Controllers;

use App\P2p\PairCoinFiat\PairCoinFiatInterface;
use Illuminate\Http\Request;

class P2PController extends Controller
{
    public function mapPairCoinToFiatsExample(Request $request, PairCoinFiatInterface $pairCoinFiat): string
    {
        try {
            $pairCoinFiat->mapFiats("USDT", ["USD"]);
            return "Success";
        } catch (\Exception $e) {
            return "Failed";
        }
    }
}
