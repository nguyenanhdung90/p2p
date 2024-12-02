<?php

namespace App\Http\Requests;

use App\Rules\ChatUserP2pTransactionRule;

class ChatP2pRequest extends BaseRequest
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
        return [
            "p2p_transaction_reference" => [
                "required",
                "string",
                new ChatUserP2pTransactionRule($this->user()->id)
            ],
            "limit" => [
                "numeric"
            ],
            "offset" => [
                "numeric"
            ]
        ];
    }
}
