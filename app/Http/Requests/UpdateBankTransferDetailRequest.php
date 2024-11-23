<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBankTransferDetailRequest extends FormRequest
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
            "id" => [
                "required",
                Rule::exists("bank_transfer_details", "id")
            ],
            "account_name" => [
                "string",
                "max:" . config("services.default_max_length_string")
            ],
            "bank_name" => [
                "string",
                "max:" . config("services.default_max_length_string")
            ],
            "bank_account" => [
                "string",
                "max:" . config("services.default_max_length_string")
            ],
            "is_active" => [
                "boolean"
            ],
            "is_default" => [
                "boolean"
            ]
        ];
    }
}
