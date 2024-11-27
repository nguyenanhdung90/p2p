<?php

namespace App\Rules;

use App\Models\ReasonP2pTransaction;
use Illuminate\Contracts\Validation\Rule;

class ValidAppealUniquePendingRule implements Rule
{
    private string $message = "Invalid pending reason";
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $reasonTransaction = ReasonP2pTransaction::where("p2p_transaction_id", $value)
            ->where("status", ReasonP2pTransaction::PENDING)
            ->first();
        if ($reasonTransaction) {
            $this->message = "Pending appeal is already existed";
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
