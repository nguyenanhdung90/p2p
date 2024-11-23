<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankTransferDetailRequest;
use App\Http\Requests\CreateCoinFiatRequest;
use App\Http\Requests\CreateP2pAdRequest;
use App\Http\Requests\DeleteCoinFiatRequest;
use App\Http\Requests\PairCoinFiatsRequest;
use App\P2p\Ads\P2pAdInterface;
use App\P2p\BankTransferDetails\BankTransferDetailInterface;
use App\P2p\PairCoinFiat\PairCoinFiatInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class P2PController extends Controller
{
    public function mapPairCoinFiats(PairCoinFiatsRequest $request, PairCoinFiatInterface $pairCoinFiat): string
    {
        try {
            $coin = $request->get('coin');
            $fiats = $request->get('fiats');
            return $pairCoinFiat->mapPairCoinFiats($coin, $fiats) ? "Success" : "Failed";
        } catch (\Exception $e) {
            return "Failed";
        }
    }

    public function createPairCoinFiat(CreateCoinFiatRequest $request,
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

    public function deletePairCoinFiat(DeleteCoinFiatRequest $request,
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

    public function getPairCoinFiatBy(Request $request,
                                             PairCoinFiatInterface $pairCoinFiat): string
    {
        $coin = $request->get("coin");
        $fiats = $request->get("fiats");
        return $pairCoinFiat->getPairCoinFiatBy($coin, $fiats);
    }

    public function createP2pAd(CreateP2pAdRequest $request, P2pAdInterface $p2pAd)
    {
        return 123;
    }

    public function createBankTransferDetail(CreateBankTransferDetailRequest $request,
                                             BankTransferDetailInterface $bankTransferDetail)
    {
        try {
            $data = $request->validated();
            $result = $bankTransferDetail->create($data);
            return response(json_encode([
                "success" => $result instanceof Model
            ]), 200);
        } catch (\Exception $e) {
            Log::error("Exception createBankTransferDetail: " . $e->getMessage());
            return response(json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]), 200);
        }
    }
}
