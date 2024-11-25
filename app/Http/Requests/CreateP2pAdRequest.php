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
        $coin = $this->get('coin');
        if (empty($coin)) {
            return [
                "coin" => ["required"]
            ];
        }
        $fiat = $this->get('fiat');
        if (empty($fiat)) {
            return [
                "fiat" => ["required"]
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
            "coin" => [
                "required",
                Rule::exists("coin_infos", "currency")->where('is_active', true)
            ],
            "fiat" => [
                "required",
                Rule::exists("fiat_infos", "currency")
            ],
            "price" => [
                "required",
                "numeric",
                "max:" . $maxFiatPrice,
                "min:0"
            ],
            "amount" => [
                "required",
                "numeric",
                "min:0"
            ],
            "minimum_amount" => [
                "required",
                "numeric",
                "min:0"
            ],
            "max_amount" => [
                "required",
                "numeric",
                "min:0",
                "max:" . $this->get('amount')
            ],
            "payment_method" => [
                "required",
                Rule::in([P2pAd::BANK_TRANSFER]),
            ],
            "payment_detail_id" => [
                "required",
                Rule::exists("bank_transfer_details", "id")
            ]
        ];
    }

    public function messages()
    {
        return [
            "coin_fiat.required" => "Coin fiat pair does not exist."
        ];
    }
}
