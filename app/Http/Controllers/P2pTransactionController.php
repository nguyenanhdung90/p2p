<?php

namespace App\Http\Controllers;

use App\Http\Requests\P2pCreateTransactionRequest;
use App\Http\Requests\PartnerTransferStatusRequest;
use App\Models\P2pTransaction;
use App\P2p\Transactions\P2pTransactionInterface;

class P2pTransactionController extends Controller
{
    public function create(P2pCreateTransactionRequest $request, P2pTransactionInterface $p2pTransaction)
    {
        try {
            $params = $request->all();
            return response(json_encode(["success" => $p2pTransaction->initiateTransaction($params)]), 200);
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }

    public function partnerTransferStatus(PartnerTransferStatusRequest $request, P2pTransactionInterface $p2pTransaction)
    {
        try {
            $id = $request->get("id");
            $params['status'] = P2pTransaction::PARTNER_TRANSFER;
            return response(json_encode(["success" => $p2pTransaction->udpate($id, $params)]), 200);
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }
}
