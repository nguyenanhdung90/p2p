<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCoinFiatRequest;
use App\Http\Requests\UpdatePairCoinFiatRequest;
use App\P2p\PairCoinFiat\PairCoinFiatInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PairCoinFiatController extends Controller
{
    public function update(UpdatePairCoinFiatRequest $request, PairCoinFiatInterface $pairCoinFiat): JsonResponse
    {
        try {
            $coin = $request->get('coin');
            $fiat = $request->get('fiat');
            $maxFiatPrice = $request->get('max_fiat_price');
            return response()->json([
                'success' => $pairCoinFiat->updatePairCoinFiat($coin, $fiat, $maxFiatPrice),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function delete(DeleteCoinFiatRequest $request, PairCoinFiatInterface $pairCoinFiat): JsonResponse
    {
        try {
            $coin = $request->get('coin');
            $fiat = $request->get('fiat');
            return response()->json([
                'success' => $pairCoinFiat->deletePairCoinFiat($coin, $fiat),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getBy(Request $request, PairCoinFiatInterface $pairCoinFiat)
    {
        $coin = $request->get("coin");
        $fiats = $request->get("fiats");
        return $pairCoinFiat->getPairCoinFiatBy($coin, $fiats);
    }
}
