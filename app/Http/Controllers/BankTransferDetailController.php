<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankTransferDetailRequest;
use App\Http\Requests\UpdateBankTransferDetailRequest;
use App\P2p\BankTransferDetails\AddBankTransferDetailInterface;
use App\P2p\BankTransferDetails\BankTransferDetailInterface;
use App\P2p\BankTransferDetails\UpdateBankTransferDetailInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BankTransferDetailController extends Controller
{
    public function create(
        CreateBankTransferDetailRequest $request,
        BankTransferDetailInterface $bankTransferDetail,
        AddBankTransferDetailInterface $addBankTransferDetail
    ) {
        try {

            $id = $addBankTransferDetail->process($request->all());
            $params = $request->only(['user_id']);
            $params['id'] = $id;
            return response(json_encode([
                "success" => $id > 0,
                'data' => $bankTransferDetail->getAllBy($params)->first()->makeHidden(["user_id", "id"])
            ]));
        } catch (\Exception $e) {
            Log::error("Exception createBankTransferDetail: " . $e->getMessage());
            return response(json_encode(["success" => false, "message" => $e->getMessage()]), 500);
        }
    }

    public function update(
        UpdateBankTransferDetailRequest $request,
        BankTransferDetailInterface $bankTransferDetail,
        UpdateBankTransferDetailInterface $updateBankTransferDetail
    )
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;
            return response(json_encode([
                "success" => $updateBankTransferDetail->process($data),
                'data' => $bankTransferDetail->getAllBy(Arr::only($data, ['id', 'user_id']))->first()
                    ->makeHidden(["user_id", "id"])
            ]),
                200);
        } catch (\Exception $e) {
            Log::error("Exception createBankTransferDetail: " . $e->getMessage());
            return response(json_encode(["success" => false, "message" => $e->getMessage()]), 500);
        }
    }

    public function getOwn(Request $request, BankTransferDetailInterface $bankTransferDetail)
    {
        $params['user_id'] = $request->user()->id;
        $params['is_active'] = true;
        return response(json_encode(["success" => true, "data" => $bankTransferDetail->getAllBy($params)]));
    }
}
