<?php

namespace App\Rules;

use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class MaxCoinAmountP2pAdRule implements Rule
{
    private string $userName;

    private string $coinCurrency;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $userName, string $coinCurrency)
    {
        $this->userName = $userName;
        $this->coinCurrency = $coinCurrency;
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
        $wallet = Wallet::where("currency", $this->coinCurrency)
            ->where("user_name", $this->userName)
            ->where("is_active", true)
            ->first();
        if (!$wallet) {
            return false;
        }
        return (int)$wallet->p2p_amount >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Amount of p2p wallet is not enough.';
    }
}
