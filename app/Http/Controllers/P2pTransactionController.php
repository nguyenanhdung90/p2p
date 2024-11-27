<?php

namespace App\Http\Controllers;

use App\Http\Requests\P2pCreateTransactionRequest;
use App\Http\Requests\PartnerTransferStatusRequest;
use App\Http\Requests\SuccessReceivedPaymentRequest;
use App\Models\P2pTransaction;
use App\P2p\Transactions\ConfirmTransferInterface;
use App\P2p\Transactions\InitiateTransactionInterface;
use App\P2p\Transactions\P2pTransactionInterface;
use Illuminate\Database\Eloquent\Model;

class P2pTransactionController extends Controller
{
    public function create(
        P2pCreateTransactionRequest $request,
        InitiateTransactionInterface $initiateTransaction,
        P2pTransactionInterface $p2pTransaction
    ) {
        try {
            $result = $initiateTransaction->process($request->all());
            $tran = $p2pTransaction->findBy($result);
            return response(json_encode([
                "success" => is_numeric($result),
                "data" => $tran instanceof Model ? $tran->toArray() : []
            ]));
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }

    public function partnerTransfer(PartnerTransferStatusRequest $request, P2pTransactionInterface $p2pTransaction)
    {
        try {
            $params['status'] = P2pTransaction::PARTNER_TRANSFER;
            $updatedTransaction = $p2pTransaction->update($request->get("id"), $params);
            return response(json_encode(["success" => $updatedTransaction instanceof Model]), 200);
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }

    public function successTransfer(SuccessReceivedPaymentRequest $request, ConfirmTransferInterface $confirmTransfer)
    {
        try {
            $data = $request->all();
            return response(json_encode(["success" => $confirmTransfer->process($data)]), 200);
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }
}
