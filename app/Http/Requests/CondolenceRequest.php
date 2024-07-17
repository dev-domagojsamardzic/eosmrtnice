<?php

namespace App\Http\Requests;

use App\Enums\CondolenceMotive;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CondolenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'motive' => ['required', Rule::enum(CondolenceMotive::class)],
            'message' => ['required', 'string', 'max:2048'],
            'recipient_full_name' => ['required', 'string', 'max:255'],
            'recipient_address' => ['required', 'string', 'max:1024'],
            'sender_full_name' => ['required', 'string', 'max:255'],
            'sender_email' => ['required', 'email', 'max:128'],
            'sender_phone' => ['required', 'string', 'max:64'],
            'sender_address' => ['required', 'string', 'max:1024'],
            'sender_additional_info' => ['nullable', 'string'],
            'package_addon' => ['sometimes', 'array'],
        ];
    }
}
