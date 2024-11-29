<?php

namespace App\Http\Requests;

use App\Rules\ValidChatP2pTransactionRule;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class CreateP2pMessageChatRequest extends BaseRequest
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
        $this->merge(["created_at" => Carbon::now()]);
        $this->merge(["updated_at" => Carbon::now()]);
        $this->merge(["by_user_id" => $this->user()->id]);
        $this->merge(["data" => json_encode(["message" => $this->get("content")])]);
        return [
            "user_chat_id" => [
                "required",
                Rule::exists("users", "id")
            ],
            "p2p_transaction_id" => [
                "required",
                new ValidChatP2pTransactionRule($this->user()->id, $this->get("user_chat_id"))
            ],
            "content" => [
                "required",
                "string"
            ]
        ];
    }
}
