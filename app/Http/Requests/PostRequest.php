<?php

namespace App\Http\Requests;

use App\Enums\PostSize;
use App\Enums\PostType;
use App\Rules\PostWordCount;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property            int             type
 * @property            int             size
 * @property            string          starts_at
 * @property            bool            is_framed
 * @property            string          deceased_full_name_lg
 * @property            string          lifespan
 * @property            string          intro_message
 * @property            string          deceased_full_name_sm
 * @property            string          main_message
 * @property            string          signature
 */
class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_admin() || is_member();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(PostType::class)],
            'size' => ['required', Rule::enum(PostSize::class), new PostWordCount()],
            'starts_at' => ['required'],
            'funeral_city_id' => [Rule::requiredIf((int)$this->type === PostType::DEATH_NOTICE->value)],
            'deceased_full_name_lg' => ['required', 'string', 'max:128'],
            'deceased_full_name_sm' => ['max:128'],
            'lifespan' => ['required', 'string', 'max:30'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'intro_message' => trim($this->intro_message, " \r\n\t"),
            'main_message' => trim($this->main_message, " \r\n\t"),
        ]);
    }

    public function messages(): array
    {
        return [
            'funeral_city_id.required' => 'Uz obavijest o smrti je obavezno naznačiti mjesto pogreba.',
        ];
    }
}
