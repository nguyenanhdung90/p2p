<?php

namespace App\Http\Requests;

use App\Rules\ImageAppealProofRule;
use App\Rules\ValidAddProofRule;
use Carbon\Carbon;

class AddProofRequest extends BaseRequest
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
        $userId = $this->user()->id;
        $this->merge(["by_user_id" => $userId]);
        $this->merge(["created_at" => Carbon::now()]);
        $this->merge(["updated_at" => Carbon::now()]);
        return [
            "reason_p2p_transactions_id" => [
                "required",
                new ValidAddProofRule($userId)
            ],
            "description" => [
                "required"
            ],
            "attachment" => [
                "required",
                new ImageAppealProofRule($this->file("attachment"))
            ]
        ];
    }
}
