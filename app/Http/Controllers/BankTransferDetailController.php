<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankTransferDetailRequest;
use App\Http\Requests\UpdateBankTransferDetailRequest;
use App\P2p\BankTransferDetails\BankTransferDetailInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BankTransferDetailController extends Controller
{
    public function createBankTransferDetail(CreateBankTransferDetailRequest $request,
                                             BankTransferDetailInterface $bankTransferDetail)
    {
        try {
            $data = $request->validated();
            $result = $bankTransferDetail->create($data);
            return response(json_encode([
                "success" => $result instanceof Model
            ]), 200);
        } catch (\Exception $e) {
            Log::error("Exception createBankTransferDetail: " . $e->getMessage());
            return response(json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]), 200);
        }
    }

    public function updateBankTransferDetail(UpdateBankTransferDetailRequest $request,
                                             BankTransferDetailInterface $bankTransferDetail)
    {
        try {
            $data = $request->validated();
            $isSuccess = $bankTransferDetail->update($data);
            return response(json_encode([
                "success" => $isSuccess
            ]), 200);
        } catch (\Exception $e) {
            Log::error("Exception createBankTransferDetail: " . $e->getMessage());
            return response(json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]), 200);
        }
    }

    public function token(Request $request)
    {
        $user = User::find(2);
        $token = $user->createToken('token-name');
        return $token->plainTextToken;
    }
}
