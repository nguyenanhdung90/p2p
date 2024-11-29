<?php

namespace App\P2p\Notifies;

interface MarkingNotifyAsReadInterface
{
    public function process(array $ids): int;
}
