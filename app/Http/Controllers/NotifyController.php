<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkingNotifyAsReadRequest;
use App\Http\Requests\NotifyRequest;
use App\P2p\Notifies\MarkingNotifyAsReadInterface;
use App\P2p\Notifies\NotifyInterface;

class NotifyController extends Controller
{
    public function getOwnBy(NotifyRequest $request, NotifyInterface $notify)
    {
        return response(json_encode([
            "success" => true,
            "data" => $notify->getBy($request->all())->makeHidden(["notifiable_type", "type"])
        ]));
    }

    public function markingAsRead(MarkingNotifyAsReadRequest $request, MarkingNotifyAsReadInterface $markingAsRead)
    {
        return response(json_encode([
            "success" => $markingAsRead->process($request->get("ids")) > 0,
        ]));
    }
}
