<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankTransferDetailRequest;
use App\Http\Requests\UpdateBankTransferDetailRequest;
use App\P2p\BankTransferDetails\BankTransferDetailInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BankTransferDetailController extends Controller
{
    public function create(CreateBankTransferDetailRequest $request, BankTransferDetailInterface $bankTransferDetail)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;
            $result = $bankTransferDetail->create($data);
            return response(json_encode([
                "success" => $result instanceof Model,
                'data' => $bankTransferDetail->getAllBy(Arr::only($data, ['id', 'user_id']))->first()
                    ->makeHidden(["user_id", "id"])
            ]), 200);
        } catch (\Exception $e) {
            Log::error("Exception createBankTransferDetail: " . $e->getMessage());
            return response(json_encode(["success" => false, "message" => $e->getMessage()]), 500);
        }
    }

    public function update(UpdateBankTransferDetailRequest $request, BankTransferDetailInterface $bankTransferDetail)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;
            return response(json_encode([
                "success" => $bankTransferDetail->update($data),
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
