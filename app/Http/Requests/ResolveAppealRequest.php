<?php

namespace App\Http\Requests;

use App\Models\ReasonP2pTransaction;
use Illuminate\Validation\Rule;

class ResolveAppealRequest extends BaseRequest
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
    public function rules()
    {
        return [
            "reason_p2p_transaction_id" => [
                "required",
                Rule::exists("reason_p2p_transactions", "id")->where(function ($query) {
                    $query->where('by_user_id', "=", $this->user()->id);
                    $query->where('status', "=", ReasonP2pTransaction::PENDING);
                })
            ]
        ];
    }
}
