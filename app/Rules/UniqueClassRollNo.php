<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\DB;
use App\Settings\GeneralSettings;

class UniqueClassRollNo implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($class_id)
    {
        $this->class_id = $class_id;
        $this->current_session_id = (new GeneralSettings)->current_session_id;
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
        $exists = DB::table('student_sessions')
            ->join('students', 'students.id', '=', 'student_sessions.student_id')
            ->where([
                'student_sessions.session_id' => $this->current_session_id,
                'student_sessions.class_id' => $this->class_id,
                'student_sessions.deleted_at' => NULL,
                'students.roll_no' => $value
            ])
            ->exists();

        if ($exists) {
            $fail('The roll no has already been taken in this class.');
        }
    }
}
