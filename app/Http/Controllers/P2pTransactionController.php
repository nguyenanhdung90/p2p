<?php

namespace App\Http\Controllers;

use App\Http\Requests\P2pCreateTransactionRequest;
use App\P2p\Transactions\P2pTransactionInterface;

class P2pTransactionController extends Controller
{
    public function create(P2pCreateTransactionRequest $request, P2pTransactionInterface $p2pTransaction)
    {
        try {
            $params = $request->all();
            return response(json_encode(["success" => true, 'data' => $p2pTransaction->create($params)]), 200);
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }
}
