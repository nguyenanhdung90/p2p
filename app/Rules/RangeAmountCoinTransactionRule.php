<?php

namespace App\Rules;

use App\Models\P2pAd;
use Illuminate\Contracts\Validation\Rule;

class RangeAmountCoinTransactionRule implements Rule
{
    private int $p2pAdId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $p2pAdId)
    {
        $this->p2pAdId = $p2pAdId;
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
        $p2pAd = P2pAd::find($this->p2pAdId);
        if ((int)$p2pAd->coin_minimum_amount > $value) {
            return false;
        }
        if ((int)$p2pAd->coin_maximum_amount < $value) {
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
        return ':attribute is invalid';
    }
}
