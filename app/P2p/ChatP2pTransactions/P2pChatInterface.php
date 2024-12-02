<?php

namespace App\P2p\ChatP2pTransactions;

interface P2pChatInterface
{
    public function getBy(array $params);

    public function find(int $id);
}
