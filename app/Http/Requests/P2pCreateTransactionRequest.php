<?php

namespace App\Http\Requests;

use App\Models\P2pAd;
use Illuminate\Validation\Rule;

class P2pCreateTransactionRequest extends BaseRequest
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

    public function rules(): array
    {
        $p2pAdId = $this->get("p2p_ad_id");
        if (empty($p2pAdId)) {
            return [
                'p2p_ad_id' => ["required"]
            ];
        }
        if (!P2pAd::find($p2pAdId)) {
            return [
                'p2p_ad_not_existed' => ["required"]
            ];
        }
        $userId = $this->user()->id;
        return [
            "p2p_ad_id" => [
                "required",
                Rule::exists("p2p_ads", "id")->where(function ($query) use ($userId) {
                    $query->where('user_id', "!=", $userId);
                    $query->where('is_active', "=", true);
                })
            ],
            "coin_amount" => [
                "required",
                "numeric",
                "min:" . P2pAd::find($p2pAdId)->coin_minimum_amount,
                "max:" . P2pAd::find($p2pAdId)->coin_maximum_amount,
            ]
        ];
    }

    public function messages()
    {
        return [
            "p2p_ad_not_existed.required" => "Ad does not exist."
        ];
    }
}
