<?php

namespace App\Http\Requests;

class NotifyRequest extends BaseRequest
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
        $this->merge(["notifiable_id" => $this->user()->id]);
        $this->merge(["type" => 'App\Notifications\Notify']);
        return [
            "is_read" => [
                "boolean"
            ]
        ];
    }
}
