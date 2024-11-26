<?php

namespace App\Rules;

use App\Models\CoinInfo;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class MinCoinAmountRule implements Rule
{
    private string $coinCurrency;

    private string $fiatCurrency;

    private int $minAmount = 0;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $coinCurrency, string $fiatCurrency)
    {
        $this->coinCurrency = $coinCurrency;
        $this->fiatCurrency = $fiatCurrency;
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
        $coinFiat = CoinInfo::whereHas('fiats', function (Builder $query) {
            $query->where('currency', '=', $this->fiatCurrency);
        })
            ->with(["fiats" => function ($queryFiat) {
                $queryFiat->where("currency", $this->fiatCurrency);
            }])
            ->where('currency', '=', $this->coinCurrency)
            ->where("is_active", true)
            ->first();
        if (empty($coinFiat->fiats->first()->pivot->min_amount_coin)) {
            return $value >= 0;
        } else {
            $this->minAmount = $coinFiat->fiats->first()->pivot->min_amount_coin;
            return $this->minAmount <= $value;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return ':attribute must be greater than ' . $this->minAmount;
    }
}
