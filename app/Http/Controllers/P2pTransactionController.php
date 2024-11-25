<?php

namespace App\Http\Controllers;

use App\Http\Requests\P2pCreateTransactionRequest;
use App\Http\Requests\P2pTransactionRequest;
use Illuminate\Http\Request;

class P2pTransactionController extends Controller
{
    public function create(P2pCreateTransactionRequest $request)
    {
        try {
            return response(json_encode(["success" => true, 'data' => 213]), 200);
        } catch (\Exception $e) {
            return response(json_encode([
                'success' => false,
                "message" => $e->getMessage()
            ]), 500);
        }
    }
}
