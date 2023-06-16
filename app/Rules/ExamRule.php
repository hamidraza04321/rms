<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Exam;

class ExamRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $exam = Exam::withoutGlobalScope(ActiveScope::class)->find($value);

        if (!$exam) {
            return $fail('The selected exam id is invalid.');
        }

        if (!$exam->is_active) {
            return $fail('The selected exam is deactive.');
        }
    }
}
