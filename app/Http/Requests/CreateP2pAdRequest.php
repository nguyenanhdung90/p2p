<?php

namespace App\Http\Requests;

use App\Models\P2pAd;
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
            ],
            "amount" => [
                "required",
            ],
            "minimum_amount" => [
                "required",
            ],
            "max_amount" => [
                "required",
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
}
