<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppealRequest;
use App\P2p\Appeal\InitiateAppealInterface;
use Illuminate\Support\Facades\Log;

class AppealController extends Controller
{
    public function create(CreateAppealRequest $request, InitiateAppealInterface $initiateAppeal)
    {
        try {
            $result = $initiateAppeal->process($request->all());
            return response(json_encode([
                "success" => is_numeric($result),
                "message" => "aaaa"
            ]));
        } catch (\Exception $e) {
            Log::error("Exception createBankTransferDetail: " . $e->getMessage());
            return response(json_encode(["success" => false, "message" => $e->getMessage()]), 500);
        }
    }
}
