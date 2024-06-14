<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PostWordCount implements ValidationRule, DataAwareRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $introMsgWordCount = str_word_count($this->data['intro_message']);
        $mainMsgWordCount = str_word_count($this->data['main_message']);
        $total = $introMsgWordCount + $mainMsgWordCount;
        $treshold = (int)$this->data['size'];

        if ($total > $treshold) {
            $fail('Prekoračili ste broj riječi za ovu veličinu oglasa');
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }
}
