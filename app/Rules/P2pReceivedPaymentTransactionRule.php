<?php

namespace App\Rules;

use App\Models\P2pTransaction;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class P2pReceivedPaymentTransactionRule implements Rule
{
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
            ->where("partner_user_id", "!=", $this->userId)
            ->where("status", P2pTransaction::PARTNER_TRANSFER)
            ->whereHas("p2pAd", function ($q) {
                $q->where("user_id", $this->userId);
                $q->where("is_active", false);
            }, "=", 1)
            ->with("p2pAd")
            ->first();

        if (!$transaction) {
            return false;
        }

        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $transaction->start_process);
        $diff = Carbon::now()->diffInSeconds($startTime);
        if ($diff > $transaction->expired_process) {
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
        return 'Invalid success transaction.';
    }
}
