<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\UserClass;

class HasUserClass implements InvokableRule
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
        if (!auth()->user()->hasRole('Super Admin')) {
            $exists = UserClass::where([
                'class_id' => $value,
                'user_id' => auth()->id()
            ])->exists();

            if (!$exists) {
                $fail('User does not have permission to this class !');
            }
        }
    }
}
