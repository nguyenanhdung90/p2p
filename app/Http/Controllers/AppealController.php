<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppealRequest;
use App\P2p\Appeal\AppealInterface;
use App\P2p\Appeal\InitiateAppealInterface;
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
}
