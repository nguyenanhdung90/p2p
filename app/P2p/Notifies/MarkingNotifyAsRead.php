<?php

namespace App\P2p\Notifies;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MarkingNotifyAsRead implements MarkingNotifyAsReadInterface
{
    public function process(array $ids): int
    {
        return DB::table("notifications")
            ->whereIn("id", $ids)->update([
                "read_at" => Carbon::now()
            ]);
    }
}
