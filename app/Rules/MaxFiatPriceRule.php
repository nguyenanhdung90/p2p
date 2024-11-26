<?php

namespace App\Rules;

use App\Models\CoinInfo;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class MaxFiatPriceRule implements Rule
{
    private string $coinCurrency;

    private string $fiatCurrency;

    private ?int $maxPrice = null;

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
     * @param  string  $attribute
     * @param  mixed  $value
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
        if (empty($coinFiat->fiats->first()->pivot->max_fiat_price)) {
            return true;
        } else {
            $this->maxPrice = $coinFiat->fiats->first()->pivot->max_fiat_price;
            return $this->maxPrice >= $value;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return !empty($this->maxPrice) ? ':attribute must be less than ' . $this->maxPrice : "Invalid :attribute";
    }
}
