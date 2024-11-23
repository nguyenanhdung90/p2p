<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateBankTransferDetailRequest extends BaseRequest
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
            "account_name" => [
                "required",
                "max:" . config("services.default_max_length_string")
            ],
            "bank_name" => [
                "required",
                "max:" . config("services.default_max_length_string")
            ],
            "bank_account" => [
                "required",
                "max:" . config("services.default_max_length_string")
            ],
        ];
    }
}
