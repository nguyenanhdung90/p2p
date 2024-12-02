<?php

namespace App\Rules;

use App\Models\P2pTransaction;
use Illuminate\Contracts\Validation\Rule;

class ChatUserP2pTransactionRule implements Rule
{
    private int $userId;

    private string $message = "Invalid chat p2p transaction.";

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $p2pTransaction = P2pTransaction::where('reference', $value)->with("p2pAd")->first();
        if (!$p2pTransaction) {
            $this->message = "Does not exist transaction.";
            return false;
        }
        $users = [$p2pTransaction->partner_user_id, $p2pTransaction->p2pAd->user_id];
        return in_array($this->userId, $users);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
