<?php

namespace App\Rules;

use App\Models\P2pTransaction;
use Illuminate\Contracts\Validation\Rule;

class ValidAppealTransactionRule implements Rule
{
    private string $message = "Invalid appeal transaction";

    private int $userId;

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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $transaction = P2pTransaction::where("id", $value)
            ->where("status", "!=", P2pTransaction::INITIATE)
            ->whereHas("p2pAd", function ($q) {
                $q->where("is_active", false);
            }, "=", 1)
            ->with("p2pAd")
            ->first();
        if (!$transaction) {
            $this->message = "Transaction does not exist.";
            return false;
        }
        $ad = $transaction->p2pAd;
        if ($this->userId != $ad->user_id && $this->userId != $transaction->partner_user_id) {
            $this->message = "Invalid user appeal transaction.";
            return false;
        }
        return true;
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
