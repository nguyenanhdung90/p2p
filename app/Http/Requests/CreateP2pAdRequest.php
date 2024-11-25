<?php

namespace App\Http\Requests;

use App\Models\CoinInfo;
use App\Models\P2pAd;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class CreateP2pAdRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $this->merge(['user_id' => $this->user()->id]);
        $coin = $this->get('coin_currency');
        if (empty($coin)) {
            return [
                "coin_currency" => ["required"]
            ];
        }
        $fiat = $this->get('fiat_currency');
        if (empty($fiat)) {
            return [
                "fiat_currency" => ["required"]
            ];
        }
        $coinFiat = CoinInfo::whereHas('fiats', function (Builder $query) use ($fiat) {
            $query->where('currency', '=', $fiat);
        })
            ->with(["fiats" => function ($query2) use ($fiat) {
                $query2->where("currency", $fiat);
            }])
            ->where('currency', '=', $coin)
            ->where("is_active", true)
            ->first();
        if (!$coinFiat) {
            return [
                "coin_fiat" => ["required"]
            ];
        }
        $maxFiatPrice = $coinFiat->fiats->first()->pivot->max_fiat_price;
        return [
            "coin_currency" => [
                "required",
                Rule::exists("coin_infos", "currency")->where('is_active', true)
            ],
            "fiat_currency" => [
                "required",
                Rule::exists("fiat_infos", "currency")
            ],
            "fiat_price" => [
                "required",
                "numeric",
                "max:" . $maxFiatPrice,
                "min:0"
            ],
            "coin_amount" => [
                "required",
                "numeric",
                "min:0"
            ],
            "coin_minimum_amount" => [
                "required",
                "numeric",
                "min:0"
            ],
            "type" => [
                "required",
                Rule::in([P2pAd::BUY, P2pAd::SELL]),
            ],
            "coin_maximum_amount" => [
                "required",
                "numeric",
                "min:0",
                "max:" . $this->get('coin_amount')
            ],
            "payment_method" => [
                "required",
                Rule::in([P2pAd::BANK_TRANSFER]),
            ],
            "bank_transfer_detail_id" => [
                "required",
                Rule::exists("bank_transfer_details", "id")
            ],
        ];
    }

    public function messages()
    {
        return [
            "coin_fiat.required" => "Coin fiat pair does not exist."
        ];
    }
}
