<?php

namespace App\Rules;

use App\Models\ReasonP2pTransaction;
use Illuminate\Contracts\Validation\Rule;

class ValidAddProofRule implements Rule
{
    private string $message = "Invalid reason p2p transaction id";

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
        $reasonTransaction = ReasonP2pTransaction::where("id", $value)
            ->where("status", ReasonP2pTransaction::PENDING)
            ->with("p2pTransaction")
            ->with("p2pTransaction.p2pAd")
            ->first();

        $p2pTransaction = $reasonTransaction->p2pTransaction;
        if (!$p2pTransaction) {
            $this->message = "Does not exist p2p transaction.";
            return false;
        }
        $p2pAd = $reasonTransaction->p2pTransaction->p2pAd;
        if (!$p2pAd) {
            $this->message = "Does not exist p2p ad.";
            return false;
        }
        if ($this->userId != $p2pTransaction->partner_user_id && $this->userId != $p2pAd->user_id) {
            $this->message = "Have no permission.";
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
