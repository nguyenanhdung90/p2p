<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProofRequest;
use App\Http\Requests\CreateAppealRequest;
use App\Http\Requests\ResolveAppealRequest;
use App\Models\ReasonP2pTransaction;
use App\P2p\Appeal\AddProofInterface;
use App\P2p\Appeal\AppealInterface;
use App\P2p\Appeal\InitiateAppealInterface;
use App\P2p\Appeal\UpdateStatusInterface;
use Illuminate\Support\Facades\Log;

class AppealController extends Controller
{
    public function create(
        CreateAppealRequest $request,
        InitiateAppealInterface $initiateAppeal,
        AppealInterface $appeal
    ) {
        try {
            $result = $initiateAppeal->process($request->all());
            return response(json_encode([
                "success" => is_numeric($result),
                "data" => $appeal->getById((int)$result)
            ]));
        } catch (\Exception $e) {
            Log::error("Exception createBankTransferDetail: " . $e->getMessage());
            return response(json_encode(["success" => false, "message" => $e->getMessage()]), 500);
        }
    }

    public function addProof(
        AddProofRequest $request,
        AddProofInterface $addProof,
        AppealInterface $appeal
    ) {
        try {
            return response(json_encode([
                "success" => $addProof->process($request->all()),
                "data" => $appeal->getById($request->get("reason_p2p_transactions_id"))
            ]));
        } catch (\Exception $e) {
            Log::error("Exception addProof: " . $e->getMessage());
            return response(json_encode(["success" => false, "message" => $e->getMessage()]), 500);
        }
    }

    public function resolveAppeal(
        AppealInterface $appeal,
        UpdateStatusInterface $updateStatus,
        ResolveAppealRequest $request
    ) {
        return response(json_encode([
            "success" => $updateStatus->process(5, ReasonP2pTransaction::RESOLVED) > 0,
            "data" => $appeal->getById($request->get("reason_p2p_transaction_id"))
        ]));
    }
}
