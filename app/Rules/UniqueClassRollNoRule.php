<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\StudentSession;
use App\Models\Scopes\ActiveScope;
use App\Settings\GeneralSettings;

class UniqueClassRollNoRule implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($class_id, $session_id, $student_session_id)
    {
        $this->class_id = $class_id;
        $this->session_id = ($session_id) ? $session_id : (new GeneralSettings)->current_session_id;
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
        $where = [
            [ 'class_id',  $this->class_id ],
            [ 'session_id', $this->session_id ]
        ];

        if ($this->student_session_id) {
            $where[] = [ 'id', '!=', $this->student_session_id ];            
        }

        $exists = StudentSession::withoutGlobalScope(ActiveScope::class)
            ->where($where)
            ->whereHas('student', function($query) use ($value){
                $query->where('roll_no', $value);
            })
            ->exists();

        if ($exists) {
            $fail('The roll no has already been taken in this class.');
        }
    }
}
