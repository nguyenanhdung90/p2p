<?php

namespace App\Http\Controllers;

use App\Http\Requests\P2pCreateTransactionRequest;
use App\Http\Requests\PartnerTransferStatusRequest;
use App\Http\Requests\SuccessReceivedPaymentRequest;
use App\Jobs\CancelExpiredP2pTransaction;
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
            if (is_numeric($result)) {
                CancelExpiredP2pTransaction::dispatch($result)->delay(10);//config("services.p2p.expired_time")
            }
            return response(json_encode([
                "success" => is_numeric($result),
                "data" => $p2pTransaction->getTranById($result)
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
            return response(json_encode([
                "success" => $updatedTransaction instanceof Model,
                "data" => $updatedTransaction instanceof Model ? $updatedTransaction->toArray() : []
            ]));
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }

    public function successTransfer(
        SuccessReceivedPaymentRequest $request,
        ConfirmTransferInterface $confirmTransfer,
        P2pTransactionInterface $p2pTransaction
    ) {
        try {
            return response(json_encode([
                "success" => $confirmTransfer->process($request->all()),
                "data" => $p2pTransaction->getTranById($request->get("id"))

            ]));
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }
}
