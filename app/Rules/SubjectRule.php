<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\HasUserClassSubject;
use App\Models\Scopes\HasSubject;
use App\Models\ClassSubject;
use App\Models\UserClassSubject;
use App\Models\Subject;

class SubjectRule implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($class_id)
    {
        $this->class_id = $class_id;
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
        $subject = Subject::withoutGlobalScope(ActiveScope::class)->find($value);

        // Check if subject exists
        if (!$subject) {
            return $fail('The selected subject id is invalid.');
        }

        // Check the Subject exists in class
        $class_subject = ClassSubject::withoutGlobalScopes([
                HasSubject::class,
                HasUserClassSubject::class
            ])
            ->where([
                'class_id' => $this->class_id,
                'subject_id' => $value
            ])->first([
                'id'
            ]);

        if (!$class_subject) {
            return $fail('The subject does not exists in this class.');
        }

        // Check user has class subject permission without super admin
        if (!auth()->user()->hasRole('Super Admin')) {
            $exists = UserClassSubject::where([
                'class_subject_id' => $class_subject->id,
                'user_id' => auth()->id()
            ])->exists();

            if (!$exists) {
                return $fail('User does not have permission to this class subject.');
            }
        }

        // Check subject is active
        if (!$subject->is_active) {
            return $fail('The selected subject is deactive.');
        }
    }
}
