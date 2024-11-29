<?php

namespace App\Rules;

use App\Models\P2pTransaction;
use Illuminate\Contracts\Validation\Rule;

class ValidChatP2pTransactionRule implements Rule
{
    private int $byUserId;

    private int $userChatId;

    private string $message = "Invalid chat users";

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $byUserId, int $userChatId)
    {
        $this->byUserId = $byUserId;
        $this->userChatId = $userChatId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $p2pTransaction = P2pTransaction::where('id', $value)->with("p2pAd")->first();
        if (!$p2pTransaction) {
            $this->message = "Does not exist transaction.";
            return false;
        }
        $users = [$p2pTransaction->partner_user_id, $p2pTransaction->p2pAd->user_id];
        return count(array_diff($users, [$this->byUserId, $this->userChatId])) === 0;
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
