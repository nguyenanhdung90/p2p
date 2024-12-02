<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Http\Requests\ChatP2pRequest;
use App\Http\Requests\CreateP2pMessageChatRequest;
use App\P2p\ChatP2pTransactions\AddMessageInterface;
use App\P2p\ChatP2pTransactions\P2pChatInterface;

class ChatController extends Controller
{
    public function createP2pChat(
        CreateP2pMessageChatRequest $request,
        AddMessageInterface $addMessage,
        P2pChatInterface $p2pChat)
    {
        $result = $addMessage->process($request->only(['p2p_transaction_id', 'by_user_id', 'user_chat_id', 'data'
            , 'created_at', 'updated_at']));
        if ($result > 0) {
            broadcast((new ChatEvent($request->get("data"), "chat-p2p-" . $request->get("user_chat_id"))))->toOthers();
        }
        return response(json_encode([
            "success" => $result > 0,
            "data" => $p2pChat->find($result)->makeHidden(["updated_at"])
        ]));
    }

    public function getChatP2pBy(ChatP2pRequest $request, P2pChatInterface $p2pChat)
    {
        $result = $p2pChat->getBy($request->all());
        $result->transform(function ($item, $key) {
            $item->user_chat_name = $item->userChat->name;
            $item->by_user_name = $item->byUser->name;
            return $item->makeHidden(["userChat", "byUser", "by_user_id", "user_chat_id", "updated_at"])->toArray();
        });
        return response(json_encode([
            "success" => true,
            "data" => $result
        ]));
    }
}
