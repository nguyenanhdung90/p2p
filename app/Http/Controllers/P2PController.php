<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCoinFiatRequest;
use App\Http\Requests\DeleteCoinFiatRequest;
use App\Http\Requests\PairCoinFiatsRequest;
use App\P2p\PairCoinFiat\PairCoinFiatInterface;
use Illuminate\Http\Request;

class P2PController extends Controller
{
    public function mapPairCoinFiatsExample(PairCoinFiatsRequest $request, PairCoinFiatInterface $pairCoinFiat): string
    {
        try {
            $coin = $request->get('coin');
            $fiats = $request->get('fiats');
            return $pairCoinFiat->mapPairCoinFiats($coin, $fiats) ? "Success" : "Failed";
        } catch (\Exception $e) {
            return "Failed";
        }
    }

    public function createPairCoinFiatExample(CreateCoinFiatRequest $request,
                                              PairCoinFiatInterface $pairCoinFiat): string
    {
        try {
            $coin = $request->get('coin');
            $fiat = $request->get('fiat');
            return $pairCoinFiat->createPairCoinFiat($coin, $fiat) ? "Success" : "Failed";
        } catch (\Exception $e) {
            return "Failed";
        }
    }

    public function deletePairCoinFiatExample(DeleteCoinFiatRequest $request,
                                              PairCoinFiatInterface $pairCoinFiat): string
    {
        try {
            $coin = $request->get('coin');
            $fiat = $request->get('fiat');
            return $pairCoinFiat->deletePairCoinFiat($coin, $fiat) ? "Success" : "Failed";
        } catch (\Exception $e) {
            return "Failed";
        }
    }

    public function getPairCoinFiatByExample(Request $request,
                                             PairCoinFiatInterface $pairCoinFiat): string
    {
        $coin = $request->get("coin");
        $fiats = $request->get("fiats");
        return $pairCoinFiat->getAllPairCoinFiat($coin, $fiats);
    }
}
