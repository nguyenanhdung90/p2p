<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProofRequest;
use App\Http\Requests\CreateAppealRequest;
use App\Http\Requests\ResolveAppealRequest;
use App\Models\ReasonP2pTransaction;
use App\Notifications\UserMailNotify;
use App\P2p\Appeals\AddProofInterface;
use App\P2p\Appeals\AppealInterface;
use App\P2p\Appeals\InitiateAppealInterface;
use App\P2p\Appeals\UpdateStatusInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AppealController extends Controller
{
    public function create(
        CreateAppealRequest $request,
        InitiateAppealInterface $initiateAppeal,
        AppealInterface $appeal
    ) {
        try {
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
            Storage::disk('public')->put("appeal_proof/" . $fileName, file_get_contents($file));
            $params = $request->except(['attachment']);
            $result = $initiateAppeal->process($params);
            if (is_numeric($result)) {
                $user = auth()->user();
                $user->notify(new UserMailNotify());
            }
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
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
            Storage::disk('public')->put("appeal_proof/" . $fileName, file_get_contents($file));
            $params = $request->except(['attachment']);
            if ($isSuccess = $addProof->process($params)) {
                $user = auth()->user();
                $user->notify(new UserMailNotify());
            }
            return response(json_encode([
                "success" => $isSuccess,
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
        $result = $updateStatus->process($request->get('reason_p2p_transaction_id'), ReasonP2pTransaction::RESOLVED);
        if ($result) {
            $user = auth()->user();
            $user->notify(new UserMailNotify());
        }
        return response(json_encode([
            "success" => $result,
            "data" => $appeal->getById($request->get("reason_p2p_transaction_id"))
        ]));
    }
}
