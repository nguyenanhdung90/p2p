<?php

namespace App\Http\Requests;

use App\Rules\ImageAppealProofRule;
use App\Rules\ValidAppealTransactionRule;
use App\Rules\ValidAppealUniquePendingRule;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class CreateAppealRequest extends BaseRequest
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
        $userid = $this->user()->id;
        $this->merge(["by_user_id" => $userid]);
        $this->merge(["created_at" => Carbon::now()]);
        $this->merge(["updated_at" => Carbon::now()]);
        return [
            "reason_id" => [
                "required",
                Rule::exists("reasons", "id")
            ],
            "p2p_transaction_id" => [
                "required",
                new ValidAppealTransactionRule($userid),
                new ValidAppealUniquePendingRule()
            ],
            "description" => [
                "required",
                "string",
                "max:1000",
            ],
            "attachment" => [
                "required",
                new ImageAppealProofRule($this->file("attachment"))
            ]
        ];
    }
}
