<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\StudentSession;

class UniqueAdmissionNoRule implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($student_session_id = null)
    {
        $this->student_session_id = $student_session_id;
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
        // Get student_id by student_session_id
        $student_id = StudentSession::withoutGlobalScopes()
            ->find($this->student_session_id)
            ?->student_id;

        // If admission no is exists
        $exists = StudentSession::withoutGlobalScopes()
            ->whereHas('student', function($query) use($value, $student_id){
                $query->where('admission_no', $value)
                    ->when($this->student_session_id, function($query) use($student_id){
                        $query->where('id', '!=', $student_id);
                    });
            })
            ->exists();

        if ($exists) {
            $fail('The admission no has already been taken.');
        }
    }
}
