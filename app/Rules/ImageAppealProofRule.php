<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ImageAppealProofRule implements Rule
{
    private UploadedFile $attachment;

    private string $message = "Invalid image attachment.";

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $extension = $this->attachment->getClientOriginalExtension();
        if (!in_array(strtolower($extension), config("services.valid_image_extensions"))) {
            $this->message = 'Invalid image, extension must be in: ' . implode(',', config("services.valid_image_extensions"));
            return false;
        }
        $size = $this->attachment->getSize();
        if ($size > 90000000) {
            $this->message = 'The size is too large, must be less than 90MB';
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
