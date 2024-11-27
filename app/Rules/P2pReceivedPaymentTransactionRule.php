<?php

namespace App\Rules;

use App\Models\P2pAd;
use App\Models\P2pTransaction;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class P2pReceivedPaymentTransactionRule implements Rule
{
    private int $userId;

    private string $message = "Invalid success transaction";

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
            ->where("status", P2pTransaction::PARTNER_TRANSFER)
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
        if ($ad->type === P2pAd::SELL) {
            if ($this->userId == $transaction->partner_user_id) {
                $this->message = "Invalid seller.";
                return false;
            }
            if ($this->userId != $ad->user_id) {
                $this->message = "Invalid buyer.";
                return false;
            }
        } else {
            if ($this->userId != $transaction->partner_user_id) {
                $this->message = "Invalid buyer.";
                return false;
            }
            if ($this->userId == $ad->user_id) {
                $this->message = "Invalid seller.";
                return false;
            }
        }

        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $transaction->start_process);
        $diff = Carbon::now()->diffInSeconds($startTime);
        if ($diff > $transaction->expired_process) {
            $this->message = "Transaction is expired.";
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
