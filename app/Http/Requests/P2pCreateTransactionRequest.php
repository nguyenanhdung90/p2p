<?php

namespace App\Http\Requests;

use App\P2p\P2pHelper;
use App\Rules\RangeAmountCoinTransactionRule;
use Carbon\Carbon;
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
        $userId = $this->user()->id;
        $name = $this->user()->name;
        $this->merge(["partner_user_id" => $userId]);
        $this->merge(["user_name" => $name]);
        $this->merge(["reference" => P2pHelper::generateRandomString()]);
        $this->merge(["expired_process" => config("services.p2p.expired_time")]);
        $this->merge(["start_process" => Carbon::now()]);
        $this->merge(["created_at" => Carbon::now()]);
        $this->merge(["updated_at" => Carbon::now()]);
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
                new RangeAmountCoinTransactionRule($this->get("p2p_ad_id")),
            ]
        ];
    }
}
