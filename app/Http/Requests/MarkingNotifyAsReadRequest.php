<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class MarkingNotifyAsReadRequest extends BaseRequest
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
            "ids" => [
                "required",
                "array",
                Rule::in("notifications", "id")->where(function ($query) {
                    $query->where('notifiable_id', "=", $this->user()->id);
                })
            ]
        ];
    }
}
