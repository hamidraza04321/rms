<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Exam;
use App\Models\Scopes\ActiveScope;

class ExamNameRule implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($session_id, $exam_id)
    {
        $this->session_id = $session_id;
        $this->exam_id = $exam_id;
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
        $where = [
            [ 'session_id', $this->session_id ],
            [ 'name', $value ]
        ];

        // Ignore in update
        if ($this->exam_id) {
            $where[] = [ 'id', '!=', $this->exam_id ];            
        }

        $exists = Exam::withoutGlobalScope(ActiveScope::class)->where($where)->exists();

        if ($exists) {
            return $fail('The exam name has already been taken in this session !');
        }
    }
}
