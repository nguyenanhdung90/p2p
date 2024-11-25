<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCoinFiatRequest;
use App\Http\Requests\MaxFiatPriceRequest;
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
            return response(json_encode([
                "success" => $pairCoinFiat->updatePairCoinFiat($coin, $fiat, $maxFiatPrice)]), 200);
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }

    public function delete(DeleteCoinFiatRequest $request, PairCoinFiatInterface $pairCoinFiat): JsonResponse
    {
        try {
            $coin = $request->get('coin');
            $fiat = $request->get('fiat');
            return response(json_encode(['success' => $pairCoinFiat->deletePairCoinFiat($coin, $fiat)]));
        } catch (\Exception $e) {
            return response([
                'success' => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getBy(Request $request, PairCoinFiatInterface $pairCoinFiat)
    {
        $coin = $request->get("coin");
        $fiats = $request->get("fiats");
        return response(json_encode(['success' => true, 'data' => $pairCoinFiat->getPairCoinFiatBy($coin, $fiats)]));
    }

    public function getMaxFiatPrice(MaxFiatPriceRequest $request, PairCoinFiatInterface $pairCoinFiat)
    {
        return response(json_encode(
            [
                'success' => true,
                'data' => [
                    'max_fiat_price' => $pairCoinFiat->getMaxFiatPriceBy($request->get("coin"), $request->get("fiat"))
                ]
            ]));
    }
}
