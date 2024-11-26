<?php

namespace App\Http\Requests;

use App\Models\P2pAd;
use App\Rules\ExistedCoinFiat;
use App\Rules\MaxCoinAmountP2pAd;
use App\Rules\MaxFiatPrice;
use App\Rules\MinCoinAmount;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class CreateP2pAdRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        $userName = $this->user()->name;
        $this->merge(['user_id' => $userid]);
        $this->merge(['user_name' => $userName]);
        $this->merge(['is_active' => true]);
        $this->merge(['created_at' => Carbon::now()]);
        $this->merge(['updated_at' => Carbon::now()]);
        return [
            "coin_currency" => [
                "required",
                Rule::exists("coin_infos", "currency")->where(function ($query) {
                    $query->where('is_active', "=", true);
                })
            ],
            "fiat_currency" => [
                "required",
                Rule::exists("fiat_infos", "currency"),
                new ExistedCoinFiat($this->get('coin_currency'))
            ],
            "fiat_price" => [
                "required",
                "numeric",
                "min:0",
                new MaxFiatPrice($this->get('coin_currency'), $this->get('fiat_currency'))
            ],
            "coin_amount" => [
                "required",
                "numeric",
                new MinCoinAmount($this->get('coin_currency'), $this->get('fiat_currency')),
                new MaxCoinAmountP2pAd($userName, $this->get('coin_currency'))
            ],
            "coin_minimum_amount" => [
                "required",
                "numeric",
                new MinCoinAmount($this->get('coin_currency'), $this->get('fiat_currency'))
            ],
            "coin_maximum_amount" => [
                "required",
                "numeric",
                "min:" . $this->get('coin_minimum_amount'),
                "max:" . $this->get('coin_amount')
            ],
            "type" => [
                "required",
                Rule::in([P2pAd::BUY, P2pAd::SELL]),
            ],
            "payment_method" => [
                "required",
                Rule::in([P2pAd::BANK_TRANSFER]),
            ],
            "bank_transfer_detail_id" => [
                "required",
                Rule::exists("bank_transfer_details", "id")->where(function ($query) use ($userid) {
                    $query->where('user_id', "=", $userid);
                })
            ],
        ];
    }
}
