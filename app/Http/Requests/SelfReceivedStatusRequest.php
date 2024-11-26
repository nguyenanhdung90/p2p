<?php

namespace App\Http\Requests;

use App\Models\P2pTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class SelfReceivedStatusRequest extends BaseRequest
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
        if (empty($this->get('id'))) {
            return [
                "id" => ["required"]
            ];
        }
        return [
            "id" => [
                "required",
                Rule::exists('p2p_transactions', 'id')->where(function ($query) use ($useId) {
                    $query->where('partner_user_id', "!=", $useId);
                    $query->where('status', "=", P2pTransaction::PARTNER_TRANSFER);
                })
            ]
        ];
    }
}
