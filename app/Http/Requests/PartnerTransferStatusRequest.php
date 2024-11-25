<?php

namespace App\Http\Requests;

use App\Models\P2pTransaction;
use Illuminate\Validation\Rule;

class PartnerTransferStatusRequest extends BaseRequest
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
        $useId = $this->user()->id;
        return [
            "id" => [
                "required",
                Rule::exists('p2p_transactions', 'id')->where(function ($query) use ($useId) {
                    $query->where('partner_user_id', "=", $useId);
                    $query->where('status', "=", P2pTransaction::INITIATE);
                })
            ]
        ];
    }
}
