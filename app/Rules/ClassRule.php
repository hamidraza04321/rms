<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\HasUserClass;
use App\Models\UserClass;
use App\Models\Classes;

class ClassRule implements InvokableRule
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
        $class = Classes::withoutGlobalScopes([
            ActiveScope::class,
            HasUserClass::class
        ])->find($value);

        // Check if class exists
        if (!$class) {
            return $fail('The selected class id is invalid.');
        }

        // Check user has class permission without super admin
        if (!auth()->user()->hasRole('Super Admin')) {
            $exists = UserClass::where([
                'class_id' => $value,
                'user_id' => auth()->id()
            ])->exists();

            if (!$exists) {
                return $fail('User does not have permission to this class.');
            }
        }

        // Check class is active
        if (!$class->is_active) {
            return $fail('The selected class id is deactive.');
        }
    }
}
