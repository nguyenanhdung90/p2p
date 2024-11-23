<?php

namespace App\Http\Requests;


use Illuminate\Validation\Rule;

class CreateCoinFiatRequest  extends BaseRequest
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
            'coin' => [
                "required",
                Rule::exists("coin_infos", "currency")->where('is_active', true)
            ],
            'fiat' => [
                "required",
                Rule::exists("fiat_infos", "currency")
            ],
        ];
    }
}
