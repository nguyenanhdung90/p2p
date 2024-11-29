<?php

namespace App\P2p\Notifies;

use Illuminate\Notifications\DatabaseNotification;

class Notify implements NotifyInterface
{
    public function getBy(array $params)
    {
        $query = DatabaseNotification::query();
        if (!empty($params['notifiable_id'])) {
            $query->where("notifiable_id", $params['notifiable_id']);
        }
        if (!empty($params['type'])) {
            $query->where("type", $params['type']);
        }
        if (isset($params['is_read'])) {
            if ($params['is_read']) {
                $query->whereNotNull("read_at");
            } else {
                $query->whereNull("read_at");
            }
        }
        $query->orderBY("created_at", "DESC");
        return $query->get();
    }
}
