<?php

namespace App\Http\Controllers;

use App\Events\NotifyEvent;
use App\Notifications\BroadcastNotifyPusher;
use App\Notifications\UserMailNotify;
use App\User;
use Illuminate\Http\Request;

class PusherController extends Controller
{
    public function getPusher(Request $request)
    {
        return view('home');
    }

    public function getEchoPusher(Request $request)
    {
        return view('echo');
    }

    public function pusher(Request $request)
    {
        //broadcast((new NotifyEvent("hello cac", "user-name")))->toOthers();
        $user = User::find(2);
        $user->notify(new UserMailNotify());
        return "pusher";
    }

    public function auth() {
        return response(json_encode([]));
    }
}
