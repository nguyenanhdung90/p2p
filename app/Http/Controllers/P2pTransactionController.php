<?php

namespace App\Http\Controllers;

use App\Events\NotifyEvent;
use App\Http\Requests\P2pCreateTransactionRequest;
use App\Http\Requests\PartnerTransferStatusRequest;
use App\Http\Requests\SuccessReceivedPaymentRequest;
use App\Jobs\CancelExpiredP2pTransaction;
use App\Models\P2pTransaction;
use App\Notifications\BroadcastNotifyPusher;
use App\Notifications\UserMailNotify;
use App\P2p\Transactions\ConfirmTransferInterface;
use App\P2p\Transactions\InitiateTransactionInterface;
use App\P2p\Transactions\P2pTransactionInterface;
use App\P2p\Transactions\UpdateP2pTransactionInterface;

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
                CancelExpiredP2pTransaction::dispatch($result)->delay(config("services.p2p.expired_time"));
                $user = auth()->user();
                $user->notify(new UserMailNotify());
                $message = "message of notify";
                broadcast((new NotifyEvent("message notify", "user-" . $user->name)))->toOthers();
                $user->notify(new BroadcastNotifyPusher(["data" => $message]));
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

    public function partnerTransfer(
        PartnerTransferStatusRequest $request,
        P2pTransactionInterface $p2pTransaction,
        UpdateP2pTransactionInterface $updateP2pTransaction
    ) {
        try {
            $params['status'] = P2pTransaction::PARTNER_TRANSFER;
            $isSuccess = $updateP2pTransaction->process($request->get("id"), $params);
            if ($isSuccess) {
                $user = auth()->user();
                $user->notify(new UserMailNotify());
                $message = "message notify";
                broadcast((new NotifyEvent("message notify", "user-" . $user->name)))->toOthers();
                $user->notify(new BroadcastNotifyPusher(["data" => $message]));
            }
            return response(json_encode([
                "success" => $isSuccess,
                "data" => $p2pTransaction->getTranById($request->get("id"))
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
            if ($isSuccess = $confirmTransfer->process($request->all())) {
                $user = auth()->user();
                $user->notify(new UserMailNotify());
                $message = "message notify";
                broadcast((new NotifyEvent("message notify", "user-" . $user->name)))->toOthers();
                $user->notify(new BroadcastNotifyPusher(["data" => $message]));
            }
            return response(json_encode([
                "success" => $isSuccess,
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
