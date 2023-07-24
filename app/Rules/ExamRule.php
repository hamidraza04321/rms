<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Exam;

class ExamRule implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($session_id)
    {
        $this->session_id = $session_id;        
    }

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

        if ($this->session_id && $this->session_id != $exam->session_id) {
            return $fail('The selected exam is not exists in session.');
        }

        if (!$exam->is_active) {
            return $fail('The selected exam is deactive.');
        }
    }
}
