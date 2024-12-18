<?php

namespace App\Http\Requests;

use App\Rules\P2pReceivedPaymentTransactionRule;

class SuccessReceivedPaymentRequest extends BaseRequest
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
        $useId = $this->user()->id;
        return [
            "id" => [
                "required",
                new P2pReceivedPaymentTransactionRule($useId)
            ]
        ];
    }
}
