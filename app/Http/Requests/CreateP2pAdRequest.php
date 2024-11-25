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
        $userid = $this->user()->id;
        $this->merge(['user_id' => $userid]);
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
            ->with(["fiats" => function ($queryFiat) use ($fiat) {
                $queryFiat->where("currency", $fiat);
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
                Rule::exists("coin_infos", "currency")->where(function ($query) {
                    $query->where('is_active', "=", true);
                })
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
                Rule::exists("bank_transfer_details", "id")->where(function ($query) use ($userid) {
                    $query->where('user_id', "=", true);
                })
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
