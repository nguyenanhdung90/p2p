<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateP2pMessageChatRequest;
use App\P2p\ChatP2pTransactions\AddMessageInterface;

class ChatController extends Controller
{
    public function createP2pChat(
        CreateP2pMessageChatRequest $request,
        AddMessageInterface $addMessage)
    {
        $result = $addMessage->process($request->only(['p2p_transaction_id', 'by_user_id', 'user_chat_id', 'data'
            , 'created_at', 'updated_at']));
        if ($result > 0) {
            broadcast((new ChatEvent($request->get("data"), "chat-p2p-" . $request->get("user_chat_id"))))->toOthers();
        }
        return response(json_encode([
            "success" => $result > 0
        ]));
    }
}
