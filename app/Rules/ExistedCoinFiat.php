<?php

namespace App\Rules;

use App\Models\CoinInfo;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class ExistedCoinFiat implements Rule
{
    private string $coinCurrency;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $coinCurrency)
    {
        $this->coinCurrency = $coinCurrency;
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
        $coinFiat = CoinInfo::whereHas('fiats', function (Builder $query) use ($value) {
            $query->where('currency', '=', $value);
        })
            ->with(["fiats" => function ($queryFiat) use ($value) {
                $queryFiat->where("currency", $value);
            }])
            ->where('currency', '=', $this->coinCurrency)
            ->where("is_active", true)
            ->first();
        if (!$coinFiat) {
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
        return 'Pair of coin fiat does not exist.';
    }
}
