<?php

namespace App\Http\Requests;

use App\Rules\P2pTransactionSelfReceivedStatus;

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
        return [
            "id" => [
                "required",
                new P2pTransactionSelfReceivedStatus($useId)
            ]
        ];
    }
}
